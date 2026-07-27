<?php
/**
 * ============================================================
 * Kode      : C_Verifikasi.php
 * Path      : Controllers/Sekretariat/C_Verifikasi.php
 * Deskripsi : Controller untuk modul Verifikasi Administrasi.
 *             Menampilkan daftar permohonan masuk (card-based),
 *             detail permohonan dengan validasi per file,
 *             dan memproses verifikasi.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Verifikasi;

class C_Verifikasi extends BaseController
{
    protected $verifikasiModel;

    public function __construct()
    {
        $this->verifikasiModel = new M_Verifikasi();
    }

    /**
     * Halaman daftar permohonan masuk - card-based layout.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // AJAX Handler for getting detail
        if ($this->request->isAJAX() && $this->request->getPost('action') === 'get_detail') {
            $id = $this->request->getPost('id');
            
            // Ambil id_bidang dari penempatan (jika sudah didisposisi)
            $penempatan = $db->table('t_penempatan_magang as pn')
                ->select('pn.id_bidang, pn.status_penempatan')
                ->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'inner')
                ->where('ps.id_permohonan_magang', $id)
                ->get()
                ->getRow();

            $bidang_list = $db->table('m_bidang')
                ->select('m_bidang.id_bidang, m_bidang.bidang, IFNULL(m_kuota.kuota, 0) as kuota')
                ->join('m_kuota', 'm_kuota.id_bidang = m_bidang.id_bidang', 'left')
                ->where('m_bidang.status_aktif', '1')
                ->get()->getResult();

            foreach ($bidang_list as &$b) {
                $activeCount = $db->table('t_penempatan_magang')
                    ->where('id_bidang', $b->id_bidang)
                    ->where('status_penempatan', 'BERJALAN')
                    ->countAllResults();
                $b->sisa_kuota = max(0, $b->kuota - $activeCount);
            }

            $data = [
                'permohonan'      => $this->verifikasiModel->getPermohonanById($id),
                'files'           => $this->verifikasiModel->getFilePermohonan($id),
                'bidang'          => $bidang_list,
                'selected_bidang' => $penempatan->id_bidang ?? null,
                'status_penempatan' => $penempatan->status_penempatan ?? 'MENUNGGU',
            ];

            return view('dashboard/sekretariat/verifikasi/_detail', $data);
        }

        $permohonan = $this->verifikasiModel->getPermohonanMasuk();
        
        // Attach files to each permohonan
        if (!empty($permohonan)) {
            $ids = array_map(function($p) { return $p->id_permohonan_magang; }, $permohonan);
            $allFiles = $this->verifikasiModel->getFilesByPermohonanIds($ids);
            
            foreach ($permohonan as &$p) {
                $p->files = $allFiles[$p->id_permohonan_magang] ?? [];
            }
        }

        $data = [
            'title'       => 'Verifikasi Permohonan',
            'active_menu' => 'verifikasi',
            'permohonan'  => $permohonan,
        ];

        return view('dashboard/sekretariat/verifikasi/index', $data);
    }

    /**
     * Proses verifikasi via AJAX Modal.
     */
    public function prosesModal()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/verifikasi'));
        }

        $id_permohonan = $this->request->getPost('id_permohonan_magang');

        // Guard: Cek apakah status sudah final
        $db = \Config\Database::connect();
        $existing = $db->table('t_persetujuan_magang as ps')
            ->select('ps.status_persetujuan, pn.status_penempatan')
            ->join('t_penempatan_magang as pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang', 'left')
            ->where('ps.id_permohonan_magang', $id_permohonan)
            ->get()
            ->getRow();

        if ($existing && $existing->status_persetujuan === 'DISETUJUI') {
            $statusPenempatan = $existing->status_penempatan ?? 'MENUNGGU';
            if ($statusPenempatan !== 'MENUNGGU') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Verifikasi tidak dapat diubah karena penempatan sudah berstatus ' . $statusPenempatan . '.'
                ]);
            }
        }

        $fileStatuses = $this->request->getPost('file_status') ?? [];
        $id_bidang = $this->request->getPost('id_bidang');

        $allValid = true;
        $anyInvalid = false;
        foreach ($fileStatuses as $status) {
            if ($status !== 'VALID') $allValid = false;
            if ($status === 'TIDAK_VALID') $anyInvalid = true;
        }

        $overallStatus = $anyInvalid ? 'PERBAIKAN_BERKAS' : 'DISETUJUI';
        $catatan = $anyInvalid ? 'Ada berkas yang tidak valid' : 'Semua berkas valid';

        // Validasi: Jika semua berkas valid (Disetujui), maka Bidang wajib dipilih
        if ($overallStatus == 'DISETUJUI' && empty($id_bidang)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Silakan pilih Bidang Tujuan untuk mendisposisikan permohonan yang disetujui.'
            ]);
        }

        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'catatan'              => $catatan,
            'status_persetujuan'   => $overallStatus,
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

        // Simpan status verifikasi per-file ke t_file_permohonan_magang
        foreach ($fileStatuses as $idFile => $status) {
            $db->table('t_file_permohonan_magang')
                ->where('id_file_permohonan_magang', $idFile)
                ->update(['status_verifikasi' => $status]);
        }

        // Jika disetujui dan id_bidang dikirim, langsung proses disposisi
        if ($overallStatus == 'DISETUJUI' && !empty($id_bidang)) {
            $db = \Config\Database::connect();
            $persetujuan = $db->table('t_persetujuan_magang')
                              ->where('id_permohonan_magang', $id_permohonan)
                              ->get()->getRow();
                              
            if ($persetujuan) {
                $disposisiModel = new \App\Models\Sekretariat\M_Disposisi();
                $disposisiModel->simpanDisposisi($persetujuan->id_persetujuan_magang, [
                    'id_bidang'         => $id_bidang,
                    'updated_by'        => session('id_user_pegawai'),
                    'catatan_disposisi' => 'Disposisi dari Verifikasi',
                ]);
            }
        }

        if ($result) {
            return $this->response->setJSON(['success' => true, 'message' => 'Verifikasi berhasil disimpan.']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal menyimpan verifikasi.']);
        }
    }

    /**
     * Kembalikan permohonan (tolak/kembalikan berkas).
     */
    public function kembalikan()
    {
        $id_permohonan = $this->request->getPost('id_permohonan_magang');
        
        $result = $this->verifikasiModel->kembalikanPermohonan($id_permohonan);

        if ($result) {
            session()->setFlashdata('success', 'Permohonan berhasil dikembalikan.');
        } else {
            session()->setFlashdata('error', 'Gagal mengembalikan permohonan.');
        }

        return redirect()->to(base_url('sekretariat/verifikasi'));
    }
}
