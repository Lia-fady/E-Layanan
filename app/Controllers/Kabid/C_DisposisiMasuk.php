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
        
        // Remove server-side filtering to allow DataTables client-side filtering
        
        $kuotaModel = new \App\Models\KuotaBidangModel();

        // Ambil data file untuk masing-masing permohonan
        foreach ($penempatan as $p) {
            $p->files = $db->table('t_file_permohonan_magang f')
                ->select('f.id_file_permohonan, f.nama_file, f.path_file as file_path, m.nama_file as jenis_file')
                ->join('m_file_permohonan mfp', 'mfp.id_file_permohonan = f.id_file_permohonan', 'left')
                ->join('m_file m', 'm.id_file = mfp.id_file', 'left')
                ->where('f.id_permohonan_magang', $p->id_permohonan_magang ?? null)
                ->get()->getResult();

            // Pengecekan Kuota Bulanan
            $cekKuota = $kuotaModel->checkKetersediaanPeriode($id_bidang, $p->tgl_mulai ?? null, $p->tgl_selesai ?? null);
            $p->kuota_warning = (!$cekKuota['status']) ? $cekKuota['pesan'] : null;
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
        $catatan       = $this->request->getPost('catatan_setuju') ?? 'Permohonan magang disetujui';

        $result = $this->penempatanModel->setujuiPenempatan(
            $id_penempatan,
            $is_log_book,
            $catatan,
            session('id_user_pegawai')
        );

        if ($result) {
            $db = \Config\Database::connect();
            $penempatan = $db->table('t_penempatan_magang')->where('id_penempatan_magang', $id_penempatan)->get()->getRow();
            $persetujuan = $db->table('t_persetujuan_magang')->where('id_persetujuan_magang', $penempatan->id_persetujuan_magang)->get()->getRow();
            
            $permohonan = $db->table('t_permohonan_magang')
                             ->select('m_jenis_permohonan.jenis_permohonan')
                             ->join('m_jenis_permohonan', 'm_jenis_permohonan.id_jenis_permohonan = t_permohonan_magang.id_jenis_permohonan', 'left')
                             ->where('t_permohonan_magang.id_permohonan_magang', $persetujuan->id_permohonan_magang)
                             ->get()->getRow();
            $jenisText = $permohonan ? strtoupper($permohonan->jenis_permohonan) : 'MAGANG';
            
            catat_log($persetujuan->id_permohonan_magang, 'Kepala Bidang', 'Penempatan Disetujui', "Mahasiswa telah disetujui dan berstatus AKTIF {$jenisText}.");
            
            session()->setFlashdata('success', 'Penempatan berhasil disetujui. Mahasiswa sekarang aktif kegiatan.');
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
            $db = \Config\Database::connect();
            $penempatan = $db->table('t_penempatan_magang')->where('id_penempatan_magang', $id_penempatan)->get()->getRow();
            $persetujuan = $db->table('t_persetujuan_magang')->where('id_persetujuan_magang', $penempatan->id_persetujuan_magang)->get()->getRow();
            catat_log($persetujuan->id_permohonan_magang, 'Kepala Bidang', 'Penempatan Ditolak/Dibatalkan', 'Catatan: ' . $catatan);
            
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
            $db = \Config\Database::connect();
            $penempatan = $db->table('t_penempatan_magang')->where('id_penempatan_magang', $id_penempatan)->get()->getRow();
            $persetujuan = $db->table('t_persetujuan_magang')->where('id_persetujuan_magang', $penempatan->id_persetujuan_magang)->get()->getRow();
            
            $permohonan = $db->table('t_permohonan_magang')
                             ->select('m_jenis_permohonan.jenis_permohonan')
                             ->join('m_jenis_permohonan', 'm_jenis_permohonan.id_jenis_permohonan = t_permohonan_magang.id_jenis_permohonan', 'left')
                             ->where('t_permohonan_magang.id_permohonan_magang', $persetujuan->id_permohonan_magang)
                             ->get()->getRow();
            $jenisText = $permohonan ? $permohonan->jenis_permohonan : 'Magang';
            
            catat_log($persetujuan->id_permohonan_magang, 'Sistem / Kepala Bidang', "Kegiatan {$jenisText} Selesai", "Masa kegiatan {$jenisText} telah diselesaikan.");
            
            session()->setFlashdata('success', 'Masa kegiatan mahasiswa berhasil diselesaikan.');
        } else {
            session()->setFlashdata('error', 'Gagal menyelesaikan magang mahasiswa.');
        }

        return redirect()->back();
    }
}
