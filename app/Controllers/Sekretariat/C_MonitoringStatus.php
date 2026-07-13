<?php
/**
 * ============================================================
 * Kode      : C_MonitoringStatus.php
 * Path      : Controllers/Sekretariat/C_MonitoringStatus.php
 * Deskripsi : Controller untuk halaman Monitoring Status.
 *             Menampilkan tabel monitoring seluruh permohonan
 *             dengan status berkas, verifikasi, dan disposisi.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;

class C_MonitoringStatus extends BaseController
{
    /**
     * Halaman monitoring status permohonan.
     *
     * @return string
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil semua permohonan dengan status terkini
        $builder = $db->table('t_permohonan_magang as pm');
        $builder->select('
            pm.id_permohonan_magang,
            pm.created_at,
            pm.posting_data,
            mhs.nim,
            mhs.nama_mahasiswa,
            jp.jenis_permohonan,
            ps.id_persetujuan_magang,
            ps.status_persetujuan,
            ps.disposisi,
            (SELECT COUNT(*) FROM t_file_permohonan_magang fp WHERE fp.id_permohonan_magang = pm.id_permohonan_magang) as total_berkas
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->where('pm.posting_data', 'kirim');
        $builder->orderBy('pm.created_at', 'DESC');

        $permohonan = $builder->get()->getResultArray();

        // Tambah required_berkas (default 3)
        foreach ($permohonan as &$p) {
            $p['required_berkas'] = 3;
        }

        $data = [
            'title'       => 'Monitoring Status',
            'active_menu' => 'monitoring',
            'permohonan'  => $permohonan,
            'info_count'  => count($permohonan),
        ];

        return view('dashboard/sekretariat/v_monitoring_status', $data);
    }
}
