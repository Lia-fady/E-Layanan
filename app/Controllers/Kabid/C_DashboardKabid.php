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

        // Hitung kuota bidang
        $kuotaRow = $db->table('m_kuota')->where('id_bidang', $id_bidang)->get()->getRow();
        $sisa_kuota = 0;
        if ($kuotaRow) {
            $sisa_kuota = max(0, $kuotaRow->kuota - $total_berjalan);
        }

        // Ambil daftar logbook menunggu persetujuan
        $logbook_list = $db->table('t_logbook_magang l')
            ->select('l.id_logbook_magang, l.tgl_logbook, l.logbook_magang, m.nama_mahasiswa')
            ->join('t_penempatan_magang p', 'p.id_penempatan_magang = l.id_penempatan_magang')
            ->join('t_persetujuan_magang ps', 'ps.id_persetujuan_magang = p.id_persetujuan_magang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang')
            ->join('m_mahasiswa m', 'm.id_mahasiswa = pm.id_mahasiswa')
            ->where('p.id_bidang', $id_bidang)
            ->where('l.disetujui_oleh', null)
            ->orderBy('l.tgl_logbook', 'ASC') // yang terlama dulu
            ->limit(5)
            ->get()->getResult();

        $semua_penempatan = $this->penempatanModel->getSemuaPenempatan($id_bidang);
        
        $penempatan_menunggu = array_filter($semua_penempatan, function($p) {
            return $p->status_penempatan == 'MENUNGGU';
        });
        $penempatan_menunggu = array_slice($penempatan_menunggu, 0, 5);

        // Ambil daftar penempatan berjalan (untuk list kecil di kanan atas/bawah)
        $penempatan_berjalan = array_filter($semua_penempatan, function($p) {
            return $p->status_penempatan == 'BERJALAN';
        });
        $penempatan_berjalan = array_slice($penempatan_berjalan, 0, 5);

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
            'penempatan_berjalan'  => $penempatan_berjalan,
            'sisa_kuota'           => $sisa_kuota,
            'logbook_list'         => $logbook_list,
            'tanggal_formatted'    => $tanggalFormatted,
        ];

        return view('dashboard/kabid/v_dashboard_kabid', $data);
    }
}
