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

class C_DisposisiMasuk extends BaseController
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

        $status_filter = $this->request->getGet('status');
        
        $penempatan = $this->penempatanModel->getSemuaPenempatan($id_bidang);
        
        // Filter penempatan based on requested status
        if ($status_filter && $status_filter != 'all') {
            $penempatan = array_filter($penempatan, function($p) use ($status_filter) {
                if ($status_filter == 'MENUNGGU') return $p->status_penempatan == '0' || $p->status_penempatan == 'MENUNGGU';
                return $p->status_penempatan == $status_filter;
            });
        }
        
        // Ambil data file untuk masing-masing permohonan
        foreach ($penempatan as $p) {
            $p->files = $db->table('t_file_permohonan_magang f')
                ->select('f.id_file_permohonan, f.nama_file, f.path_file as file_path, m.nama_file as jenis_file')
                ->join('m_file_permohonan mfp', 'mfp.id_file_permohonan = f.id_file_permohonan', 'left')
                ->join('m_file m', 'm.id_file = mfp.id_file', 'left')
                ->where('f.id_permohonan_magang', $p->id_permohonan_magang ?? null)
                ->get()->getResult();
        }

        $data = [
            'title'         => 'Data Mahasiswa Bidang',
            'active_menu'   => 'disposisi',
            'penempatan'    => $penempatan,
            'status_filter' => $status_filter ?? 'all'
        ];

        return view('dashboard/kabid/v_disposisi_masuk', $data);
    }

    /**
     * Proses setujui penempatan.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function setujui()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');
        $is_log_book   = $this->request->getPost('is_log_book'); // 'Ya' atau 'Tidak'

        // CEK KUOTA DULU
        $detailPenempatan = $this->penempatanModel->getDetailPenempatan($id_penempatan);
        if ($detailPenempatan && isset($detailPenempatan->id_bidang)) {
            $kuotaModel = new \App\Models\KuotaBidangModel();
            $kuotaInfo = $kuotaModel->getSisaKuota($detailPenempatan->id_bidang);
            
            if ($kuotaInfo['sisa'] <= 0) {
                session()->setFlashdata('error', 'Kuota penuh. Proses persetujuan tidak dapat dilanjutkan.');
                return redirect()->to(base_url('kabid/disposisi'));
            }
        }

        $result = $this->penempatanModel->setujuiPenempatan(
            $id_penempatan,
            $is_log_book,
            session('id_user_pegawai')
        );

        if ($result) {
            session()->setFlashdata('success', 'Penempatan berhasil disetujui. Mahasiswa sekarang aktif magang.');
        } else {
            session()->setFlashdata('error', 'Gagal menyetujui penempatan.');
        }

        return redirect()->to(base_url('kabid/disposisi'));
    }

    /**
     * Proses tolak penempatan.
     * Mengubah status menjadi DIBATALKAN.
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
            session()->setFlashdata('success', 'Penempatan dibatalkan.');
        } else {
            session()->setFlashdata('error', 'Gagal menolak penempatan.');
        }

        return redirect()->to(base_url('kabid/disposisi'));
    }

    /**
     * Proses selesaikan magang.
     * Mengubah status menjadi SELESAI.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function selesaikan()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');

        $result = $this->penempatanModel->selesaikanPenempatan(
            $id_penempatan,
            session('id_user_pegawai')
        );

        if ($result) {
            session()->setFlashdata('success', 'Masa magang mahasiswa berhasil diselesaikan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyelesaikan magang mahasiswa.');
        }

        return redirect()->back();
    }
}
