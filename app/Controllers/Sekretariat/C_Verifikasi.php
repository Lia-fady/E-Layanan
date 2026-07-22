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
            'title'       => 'Verifikasi Berkas',
            'active_menu' => 'verifikasi',
            'permohonan'  => $permohonan,
        ];

        return view('dashboard/sekretariat/v_verifikasi', $data);
    }

    /**
     * Data untuk modal detail permohonan.
     */
    public function detailModal($id)
    {
        $db = \Config\Database::connect();
        
        $data = [
            'permohonan'  => $this->verifikasiModel->getPermohonanById($id),
            'files'       => $this->verifikasiModel->getFilePermohonan($id),
            'bidang'      => $db->table('m_bidang')->where('status_aktif', '1')->get()->getResult(),
        ];

        return view('dashboard/sekretariat/v_verifikasi_modal', $data);
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

        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'catatan'              => $catatan,
            'status_persetujuan'   => $overallStatus,
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

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
