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
        
        // Ambil semua penempatan yang BUKAN menunggu
        $penempatan = $this->penempatanModel->getSemuaPenempatan($id_bidang, ['BERJALAN', 'SELESAI', 'DITOLAK', 'DIBATALKAN']);
        
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
}
