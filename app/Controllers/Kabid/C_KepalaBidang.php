<?php
/**
 * ============================================================
 * Kode      : C_KepalaBidang.php
 * Path      : Controllers/Kabid/C_KepalaBidang.php
 * Deskripsi : Controller untuk modul Persetujuan Penempatan
 *             Kepala Bidang. Menampilkan daftar penempatan
 *             menunggu persetujuan, proses setujui dan tolak.
 * ============================================================
 */

namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Models\Kabid\M_Penempatan;

class C_KepalaBidang extends BaseController
{
    protected $penempatanModel;

    public function __construct()
    {
        $this->penempatanModel = new M_Penempatan();
    }

    /**
     * Halaman daftar penempatan yang menunggu persetujuan.
     *
     * @return string
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil id_bidang user yang login
        $id_user = session('id_user_pegawai');
        $user = $db->table('c_user_pegawai')
            ->where('id_user_pegawai', $id_user)
            ->get()
            ->getRow();

        $id_bidang = $user->id_bidang ?? null;

        $data = [
            'title'       => 'Persetujuan Penempatan',
            'active_menu' => 'penempatan',
            'penempatan'  => $this->penempatanModel->getPenempatanMenunggu($id_bidang),
        ];

        return view('dashboard/kabid/v_penempatan', $data);
    }

    /**
     * Proses setujui penempatan.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function setujui()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');

        $result = $this->penempatanModel->setujuiPenempatan(
            $id_penempatan,
            session('id_user_pegawai')
        );

        if ($result) {
            session()->setFlashdata('success', 'Penempatan berhasil disetujui. Mahasiswa sekarang aktif magang.');
        } else {
            session()->setFlashdata('error', 'Gagal menyetujui penempatan.');
        }

        return redirect()->to(base_url('kabid/penempatan'));
    }

    /**
     * Proses tolak penempatan.
     * Record penempatan dihapus dan disposisi direset
     * agar muncul kembali di Disposisi Sekretariat.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function tolak()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');
        $catatan = $this->request->getPost('catatan_tolak') ?? 'Ditolak oleh Kepala Bidang';

        $result = $this->penempatanModel->tolakPenempatan(
            $id_penempatan,
            $catatan,
            session('id_user_pegawai')
        );

        if ($result) {
            session()->setFlashdata('success', 'Penempatan ditolak. Permohonan dikembalikan ke Disposisi Sekretariat.');
        } else {
            session()->setFlashdata('error', 'Gagal menolak penempatan.');
        }

        return redirect()->to(base_url('kabid/penempatan'));
    }
}
