<?php
/**
 * ============================================================
 * Kode      : C_Verifikasi.php
 * Path      : Controllers/Sekretariat/C_Verifikasi.php
 * Deskripsi : Controller untuk modul Verifikasi Administrasi.
 *             Menampilkan daftar permohonan masuk,
 *             detail permohonan, dan memproses verifikasi
 *             (setujui / tolak).
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
     * Halaman daftar permohonan masuk yang perlu diverifikasi.
     *
     * @return string
     */
    public function index()
    {
        $data = [
            'title'       => 'Verifikasi Administrasi',
            'active_menu' => 'verifikasi',
            'permohonan'  => $this->verifikasiModel->getPermohonanMasuk(),
        ];

        return view('dashboard/sekretariat/v_verifikasi', $data);
    }

    /**
     * Halaman detail permohonan beserta file lampiran.
     *
     * @param int $id ID permohonan magang
     * @return string
     */
    public function detail($id)
    {
        $data = [
            'title'       => 'Detail Permohonan',
            'active_menu' => 'verifikasi',
            'permohonan'  => $this->verifikasiModel->getPermohonanById($id),
            'files'       => $this->verifikasiModel->getFilePermohonan($id),
        ];

        return view('dashboard/sekretariat/v_verifikasi_detail', $data);
    }

    /**
     * Proses form verifikasi (setujui / tolak).
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function proses()
    {
        $data = [
            'id_permohonan_magang' => $this->request->getPost('id_permohonan_magang'),
            'catatan'              => $this->request->getPost('catatan'),
            'status_persetujuan'   => $this->request->getPost('status_persetujuan'),
            'created_by'           => session('id_user_pegawai'),
            'updated_by'           => session('id_user_pegawai'),
        ];

        $result = $this->verifikasiModel->simpanVerifikasi($data);

        if ($result) {
            session()->setFlashdata('success', 'Verifikasi berhasil disimpan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan verifikasi. Silakan coba lagi.');
        }

        return redirect()->to(base_url('sekretariat/verifikasi'));
    }
}
