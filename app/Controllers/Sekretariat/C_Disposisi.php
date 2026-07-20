<?php
/**
 * ============================================================
 * Kode      : C_Disposisi.php
 * Path      : Controllers/Sekretariat/C_Disposisi.php
 * Deskripsi : Controller untuk modul Disposisi Bidang.
 *             Menampilkan daftar permohonan yang sudah
 *             diverifikasi (disetujui) untuk didisposisikan
 *             ke bidang terkait.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_Disposisi;

class C_Disposisi extends BaseController
{
    protected $disposisiModel;

    public function __construct()
    {
        $this->disposisiModel = new M_Disposisi();
    }

    /**
     * Halaman daftar permohonan yang siap didisposisikan.
     *
     * @return string
     */
    public function index()
    {
        $data = [
            'title'       => 'Disposisi ke Bidang',
            'active_menu' => 'disposisi',
            'permohonan'  => $this->disposisiModel->getPermohonanDisetujui(),
            'bidang'      => $this->disposisiModel->getBidangAktif(),
        ];

        return view('dashboard/sekretariat/v_disposisi', $data);
    }

    /**
     * Halaman detail disposisi dan form pemilihan bidang.
     *
     * @param int $id ID persetujuan magang
     * @return string
     */
    public function detail($id)
    {
        $data = [
            'title'       => 'Disposisi ke Bidang',
            'active_menu' => 'disposisi',
            'permohonan'  => $this->disposisiModel->getDisposisiById($id),
            'bidang'      => $this->disposisiModel->getBidangAktif(),
        ];

        return view('dashboard/sekretariat/v_disposisi_detail', $data);
    }

    /**
     * Proses form disposisi ke bidang.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function proses()
    {
        $id_persetujuan = $this->request->getPost('id_persetujuan_magang');

        $data = [
            'id_bidang'          => $this->request->getPost('id_bidang'),
            'updated_by'         => session('id_user_pegawai'),
            'catatan_disposisi'  => $this->request->getPost('catatan_disposisi'),
        ];

        $result = $this->disposisiModel->simpanDisposisi($id_persetujuan, $data);

        if ($result) {
            session()->setFlashdata('success', 'Disposisi berhasil disimpan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyimpan disposisi. Silakan coba lagi.');
        }

        return redirect()->to(base_url('sekretariat/disposisi'));
    }
}
