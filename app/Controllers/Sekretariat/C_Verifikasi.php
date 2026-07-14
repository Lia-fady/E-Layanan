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
     * Halaman detail permohonan dengan validasi per-file.
     */
    public function detail($id)
    {
        $data = [
            'title'       => 'Detail Verifikasi Berkas',
            'active_menu' => 'verifikasi',
            'permohonan'  => $this->verifikasiModel->getPermohonanById($id),
            'files'       => $this->verifikasiModel->getFilePermohonan($id),
        ];

        return view('dashboard/sekretariat/v_verifikasi_detail', $data);
    }

    /**
     * Proses verifikasi per-file dan tentukan status keseluruhan.
     */
    public function proses()
    {
        $id_permohonan = $this->request->getPost('id_permohonan_magang');
        $fileStatuses = $this->request->getPost('file_status') ?? [];

        // Update status per file
        foreach ($fileStatuses as $fileId => $status) {
            if (!empty($status)) {
                $this->verifikasiModel->updateFileStatus($fileId, $status);
            }
        }

        // Determine file status metrics for notes
        $allValid = true;
        $anyInvalid = false;
        foreach ($fileStatuses as $status) {
            if ($status !== 'VALID') $allValid = false;
            if ($status === 'TIDAK_VALID') $anyInvalid = true;
        }

        // Determine overall status (selalu DISETUJUI sesuai request)
        $overallStatus = 'DISETUJUI';

        // Save overall verification
        $data = [
            'id_permohonan_magang' => $id_permohonan,
            'catatan'              => $anyInvalid ? 'Ada berkas yang tidak valid' : ($allValid ? 'Semua berkas valid' : ''),
            'status_persetujuan'   => $overallStatus,
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

        if ($result) {
            session()->setFlashdata('success', 'Verifikasi berhasil disimpan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan verifikasi.');
        }

        return redirect()->to(base_url('sekretariat/verifikasi'));
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
