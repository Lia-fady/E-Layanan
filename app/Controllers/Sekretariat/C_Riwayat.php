<?php
/**
 * ============================================================
 * Kode      : C_Riwayat.php
 * Path      : Controllers/Sekretariat/C_Riwayat.php
 * Deskripsi : Controller untuk halaman Riwayat Permohonan.
 *             Menampilkan semua permohonan dengan semua status,
 *             mendukung edit verifikasi dan edit disposisi.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Verifikasi;

class C_Riwayat extends BaseController
{
    protected $verifikasiModel;

    public function __construct()
    {
        $this->verifikasiModel = new M_Verifikasi();
    }

    /**
     * Halaman riwayat semua permohonan.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_permohonan_magang as pm');
        $builder->select('
            pm.id_permohonan_magang,
            pm.created_at as tgl_pengajuan,
            MAX(mhs.nim) as nim,
            MAX(mhs.nama_mahasiswa) as nama_mahasiswa,
            MAX(jp.jenis_permohonan) as jenis_permohonan,
            MAX(ip.instansi_pendidikan) as instansi_pendidikan,
            COALESCE(MAX(ps.status_persetujuan), "MENUNGGU") as status_persetujuan,
            MAX(ps.disposisi) as disposisi,
            MAX(ps.id_bidang) as id_bidang,
            MAX(ps.id_persetujuan_magang) as id_persetujuan_magang,
            MAX(bd.bidang) as bidang,
            MAX(pn.id_penempatan_magang) as id_penempatan_magang,
            MAX(pn.status_penempatan) as status_penempatan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = ps.id_bidang', 'left');
        $builder->join('t_penempatan_magang as pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang', 'left');
        $builder->where('pm.posting_data', 'kirim');
        $builder->whereIn('ps.status_persetujuan', ['DISETUJUI', 'DITOLAK', 'PERBAIKAN_BERKAS']);
        $builder->groupBy('pm.id_permohonan_magang');
        $builder->orderBy('pm.created_at', 'DESC');

        // Ambil daftar bidang aktif untuk dropdown edit disposisi
        $bidang = $db->table('m_bidang')
            ->where('status_aktif', '1')
            ->get()
            ->getResult();

        $data = [
            'title'       => 'Riwayat Permohonan',
            'active_menu' => 'riwayat',
            'permohonan'  => $builder->get()->getResult(),
            'bidang'      => $bidang,
        ];

        return view('dashboard/sekretariat/v_riwayat', $data);
    }

    /**
     * Setujui permohonan langsung dari halaman riwayat.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function setujui()
    {
        $id_permohonan = $this->request->getPost('id_permohonan_magang');

        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'catatan'              => 'Disetujui dari halaman riwayat',
            'status_persetujuan'   => 'DISETUJUI',
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

        if ($result) {
            session()->setFlashdata('success', 'Permohonan berhasil disetujui.');
        } else {
            session()->setFlashdata('error', 'Gagal menyetujui permohonan.');
        }

        return redirect()->to(base_url('sekretariat/riwayat'));
    }

    /**
     * Tolak permohonan langsung dari halaman riwayat.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function tolak()
    {
        $id_permohonan = $this->request->getPost('id_permohonan_magang');

        $result = $this->verifikasiModel->kembalikanPermohonan($id_permohonan);

        if ($result) {
            session()->setFlashdata('success', 'Permohonan berhasil ditolak.');
        } else {
            session()->setFlashdata('error', 'Gagal menolak permohonan.');
        }

        return redirect()->to(base_url('sekretariat/riwayat'));
    }

    /**
     * Edit disposisi bidang dari halaman riwayat.
     * Mengubah bidang tujuan pada t_persetujuan_magang
     * dan update t_penempatan_magang terkait jika ada.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function editDisposisi()
    {
        $id_persetujuan = $this->request->getPost('id_persetujuan_magang');
        $id_bidang_baru = $this->request->getPost('id_bidang');

        if (empty($id_persetujuan) || empty($id_bidang_baru)) {
            session()->setFlashdata('error', 'Data tidak lengkap.');
            return redirect()->to(base_url('sekretariat/riwayat'));
        }

        $db = \Config\Database::connect();

        // 1. Update bidang di t_persetujuan_magang
        $result = $db->table('t_persetujuan_magang')
            ->where('id_persetujuan_magang', $id_persetujuan)
            ->update([
                'id_bidang'  => $id_bidang_baru,
                'updated_by' => session('id_user_pegawai'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        // 2. Update bidang di t_penempatan_magang jika ada record terkait
        $penempatan = $db->table('t_penempatan_magang')
            ->where('id_persetujuan_magang', $id_persetujuan)
            ->get()
            ->getRow();

        if ($penempatan) {
            $db->table('t_penempatan_magang')
                ->where('id_persetujuan_magang', $id_persetujuan)
                ->update([
                    'id_bidang'  => $id_bidang_baru,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        }

        if ($result) {
            session()->setFlashdata('success', 'Disposisi bidang berhasil diubah.');
        } else {
            session()->setFlashdata('error', 'Gagal mengubah disposisi bidang.');
        }

        return redirect()->to(base_url('sekretariat/riwayat'));
    }

    /**
     * Hapus data riwayat permohonan magang beserta seluruh relasinya.
     * 
     * Urutan FK CASCADE yang sudah ada di database:
     * 1. DELETE t_permohonan_magang → CASCADE ke:
     *    - t_file_permohonan_magang (ON DELETE CASCADE)
     *    - t_log_permohonan (ON DELETE CASCADE)
     *    - t_persetujuan_magang (ON DELETE CASCADE) → CASCADE ke:
     *      - t_penempatan_magang (ON DELETE CASCADE) → CASCADE ke:
     *        - t_logbook_magang (ON DELETE CASCADE)
     *      - t_file_proses_magang (ON DELETE CASCADE)
     *
     * Yang TIDAK memiliki FK CASCADE:
     * - t_penilaian_magang (harus dihapus manual sebelum cascade)
     */
    public function delete()
    {
        // Validasi: Hanya terima request AJAX
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/riwayat'));
        }

        // Validasi: ID harus ada dan valid
        $id_permohonan = $this->request->getPost('id_permohonan_magang');
        if (empty($id_permohonan) || !is_numeric($id_permohonan)) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'ID permohonan tidak valid.'
            ]);
        }

        // Validasi: User Sekretariat harus login
        if (empty(session('id_user_pegawai'))) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Anda tidak memiliki hak akses untuk menghapus data.'
            ]);
        }

        $db = \Config\Database::connect();

        // Validasi: Data permohonan harus ada di database
        $permohonan = $db->table('t_permohonan_magang')
            ->where('id_permohonan_magang', $id_permohonan)
            ->get()
            ->getRow();

        if (!$permohonan) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Data permohonan tidak ditemukan di database.'
            ]);
        }

        // Kumpulkan path file fisik yang perlu dihapus SEBELUM transaksi
        $filesToDelete = [];

        // File permohonan (uploads/dokumen)
        $filePermohonan = $db->table('t_file_permohonan_magang')
            ->where('id_permohonan_magang', $id_permohonan)
            ->get()->getResult();
        foreach ($filePermohonan as $f) {
            if (!empty($f->path_file)) {
                $filesToDelete[] = FCPATH . $f->path_file;
            }
        }

        // File proses magang (surat penerimaan, dll)
        $persetujuan = $db->table('t_persetujuan_magang')
            ->where('id_permohonan_magang', $id_permohonan)
            ->get()->getRow();

        if ($persetujuan) {
            $fileProses = $db->table('t_file_proses_magang')
                ->where('id_persetujuan_magang', $persetujuan->id_persetujuan_magang)
                ->get()->getResult();
            foreach ($fileProses as $fp) {
                if (!empty($fp->path_file)) {
                    $filesToDelete[] = FCPATH . $fp->path_file;
                }
            }

            // Hapus t_penilaian_magang (TIDAK ada FK CASCADE)
            $penempatan = $db->table('t_penempatan_magang')
                ->where('id_persetujuan_magang', $persetujuan->id_persetujuan_magang)
                ->get()->getResult();
            
            $penempatanIds = array_map(function($p) { return $p->id_penempatan_magang; }, $penempatan);
        }

        // Mulai transaksi database
        $db->transStart();

        try {
            // 1. Hapus t_penilaian_magang secara manual (tidak ada FK)
            if (!empty($penempatanIds)) {
                $db->table('t_penilaian_magang')
                    ->whereIn('id_penempatan_magang', $penempatanIds)
                    ->delete();
            }

            // 2. Hapus t_permohonan_magang — FK CASCADE akan otomatis menghapus:
            //    t_file_permohonan_magang, t_log_permohonan,
            //    t_persetujuan_magang → t_penempatan_magang → t_logbook_magang, t_file_proses_magang
            $db->table('t_permohonan_magang')
                ->where('id_permohonan_magang', $id_permohonan)
                ->delete();

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Gagal menghapus riwayat permohonan ID ' . $id_permohonan . ': ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Terjadi kesalahan database saat menghapus data: ' . $e->getMessage()
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Gagal menghapus data riwayat. Transaksi database dibatalkan.'
            ]);
        }

        // Hapus file fisik setelah transaksi database berhasil
        foreach ($filesToDelete as $filePath) {
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }

        return $this->response->setJSON([
            'success' => true, 
            'message' => 'Data riwayat permohonan berhasil dihapus beserta seluruh data terkait.'
        ]);
    }
}
