<?php
/**
 * ============================================================
 * Kode      : C_DashboardKabid.php
 * Path      : Controllers/Kabid/C_DashboardKabid.php
 * Deskripsi : Controller untuk Dashboard Kepala Bidang.
 *             Menampilkan ringkasan penempatan yang menunggu
 *             persetujuan dan statistik bidang.
 * ============================================================
 */

namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Models\Kabid\M_Penempatan;

class C_DashboardKabid extends BaseController
{
    protected $penempatanModel;

    public function __construct()
    {
        $this->penempatanModel = new M_Penempatan();
    }

    /**
     * Halaman dashboard Kepala Bidang.
     *
     * @return string
     */
    public function index(): string
    {
        $db = \Config\Database::connect();

        // Ambil id_bidang user yang login
        $id_user = session('id_user_pegawai');
        $user = $db->table('c_user_pegawai')
            ->where('id_user_pegawai', $id_user)
            ->get()
            ->getRow();

        $id_bidang = $user->id_bidang ?? null;

        // Hitung penempatan menunggu
        $total_menunggu = $this->penempatanModel->countPenempatanMenunggu($id_bidang);

        // Hitung penempatan berjalan
        $total_berjalan = $db->table('t_penempatan_magang')
            ->where('status_penempatan', 'BERJALAN');
        if ($id_bidang) {
            $total_berjalan->where('id_bidang', $id_bidang);
        }
        $total_berjalan = $total_berjalan->countAllResults();

        // Hitung penempatan selesai
        $total_selesai = $db->table('t_penempatan_magang')
            ->where('status_penempatan', 'SELESAI');
        if ($id_bidang) {
            $total_selesai->where('id_bidang', $id_bidang);
        }
        $total_selesai = $total_selesai->countAllResults();

        // Ambil nama bidang
        $bidang_info = null;
        if ($id_bidang) {
            $bidang_info = $db->table('m_bidang')
                ->where('id_bidang', $id_bidang)
                ->get()
                ->getRow();
        }

        // Ambil daftar penempatan menunggu (5 terbaru)
        $penempatan_menunggu = $this->penempatanModel->getPenempatanMenunggu($id_bidang);
        $penempatan_menunggu = array_slice($penempatan_menunggu, 0, 5);

        // Format tanggal Indonesia
        $namaBulan = [
            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret',
            '04' => 'April',   '05' => 'Mei',      '06' => 'Juni',
            '07' => 'Juli',    '08' => 'Agustus',   '09' => 'September',
            '10' => 'Oktober', '11' => 'November',  '12' => 'Desember',
        ];
        $namaHari = [
            'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        $namaBulanIni = $namaBulan[date('m')] ?? date('F');
        $hariNamaIni = $namaHari[date('l')] ?? date('l');
        $tanggalFormatted = $hariNamaIni . ', ' . date('d') . ' ' . $namaBulanIni . ' ' . date('Y');

        $data = [
            'title'                => 'Dashboard Kepala Bidang',
            'active_menu'          => 'dashboard',
            'total_menunggu'       => $total_menunggu,
            'total_berjalan'       => $total_berjalan,
            'total_selesai'        => $total_selesai,
            'bidang_info'          => $bidang_info,
            'penempatan_menunggu'  => $penempatan_menunggu,
            'tanggal_formatted'    => $tanggalFormatted,
        ];

        return view('dashboard/kabid/v_dashboard_kabid', $data);
    }
}
