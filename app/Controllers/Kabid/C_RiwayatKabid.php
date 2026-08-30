<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Models\Kabid\M_Penempatan;

class C_RiwayatKabid extends BaseController
{
    protected $penempatanModel;

    public function __construct()
    {
        $this->penempatanModel = new M_Penempatan();
    }

    public function index()
    {
        $db = \Config\Database::connect();

        $id_user = session('id_user_pegawai');
        $user = $db->table('c_user_pegawai')
            ->where('id_user_pegawai', $id_user)
            ->get()
            ->getRow();

        $id_bidang = $user->id_bidang ?? null;

        // Lazy check: Update status otomatis berdasarkan tanggal
        $this->penempatanModel->updateStatusOtomatis($id_bidang);
        
        // Ambil semua penempatan yang BUKAN menunggu (termasuk DISETUJUI dan DITOLAK)
        $penempatan = $this->penempatanModel->getSemuaPenempatan($id_bidang, ['DISETUJUI', 'BERJALAN', 'SELESAI', 'DITOLAK', 'DIBATALKAN']);
        
        // Ambil data file untuk masing-masing permohonan (jika dibutuhkan di list)
        foreach ($penempatan as $p) {
            $p->files = $db->table('t_file_permohonan_magang f')
                ->select('f.id_file_permohonan, f.nama_file, f.path_file as file_path, m.nama_file as jenis_file')
                ->join('m_file_permohonan mfp', 'mfp.id_file_permohonan = f.id_file_permohonan', 'left')
                ->join('m_file m', 'm.id_file = mfp.id_file', 'left')
                ->where('f.id_permohonan_magang', $p->id_permohonan_magang ?? null)
                ->get()->getResult();
        }

        // AJAX Handler for getting detail
        if ($this->request->isAJAX() && $this->request->getPost('action') === 'get_detail') {
            $id_penempatan = $this->request->getPost('id_penempatan');
            
            $penempatanDetail = $this->penempatanModel->getDetailPenempatan($id_penempatan);
            
            if (!$penempatanDetail) {
                return $this->response->setJSON(['error' => true, 'message' => 'Data tidak ditemukan']);
            }

            // Ambil data file untuk permohonan ini
            $files = $db->table('t_file_permohonan_magang f')
                ->select('f.id_file_permohonan, f.nama_file, f.path_file as file_path, m.nama_file as jenis_file')
                ->join('m_file_permohonan mfp', 'mfp.id_file_permohonan = f.id_file_permohonan', 'left')
                ->join('m_file m', 'm.id_file = mfp.id_file', 'left')
                ->where('f.id_permohonan_magang', $penempatanDetail->id_permohonan_magang ?? null)
                ->get()->getResult();

            $dataDetail = [
                'p' => $penempatanDetail,
                'files' => $files
            ];

            return view('dashboard/kabid/riwayat/_detail', $dataDetail);
        }

        $data = [
            'title'         => 'Riwayat Penempatan Bidang',
            'active_menu'   => 'riwayat',
            'penempatan'    => $penempatan,
            'status_filter' => $status_filter ?? 'all'
        ];

        return view('dashboard/kabid/riwayat/index', $data);
    }

    /**
     * Proses batalkan penempatan (saat status DISETUJUI atau BERJALAN).
     * Mahasiswa mengundurkan diri — status final DIBATALKAN.
     */
    public function batalkan()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');
        $catatan = $this->request->getPost('catatan_batalkan')
            ?? $this->request->getPost('catatan_keputusan')
            ?? 'Dibatalkan oleh Kepala Bidang';

        $result = $this->penempatanModel->batalkanPenempatan(
            $id_penempatan,
            $catatan,
            session('id_user_pegawai')
        );

        if ($result) {
            $db = \Config\Database::connect();
            $penempatan = $db->table('t_penempatan_magang')->where('id_penempatan_magang', $id_penempatan)->get()->getRow();
            $persetujuan = $db->table('t_persetujuan_magang')->where('id_persetujuan_magang', $penempatan->id_persetujuan_magang)->get()->getRow();
            
            catat_log($persetujuan->id_permohonan_magang, 'Kepala Bidang', 'Kegiatan Dibatalkan', 'Kegiatan dibatalkan. Catatan: ' . $catatan);
            
            session()->setFlashdata('success', 'Kegiatan berhasil dibatalkan.');
        } else {
            session()->setFlashdata('error', 'Gagal membatalkan kegiatan. Pastikan status penempatan masih Disetujui atau Berjalan.');
        }

        return redirect()->back();
    }
}
