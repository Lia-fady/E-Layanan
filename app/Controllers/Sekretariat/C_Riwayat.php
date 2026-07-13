<?php
/**
 * ============================================================
 * Kode      : C_Riwayat.php
 * Path      : Controllers/Sekretariat/C_Riwayat.php
 * Deskripsi : Controller untuk halaman Riwayat Permohonan.
 *             Menampilkan semua permohonan dengan semua status.
 * ============================================================
 */

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;

class C_Riwayat extends BaseController
{
    /**
     * Halaman riwayat semua permohonan.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_permohonan_magang as pm');
        $builder->select('
            pm.id_permohonan_magang,
            pm.created_at as tgl_pengajuan,
            mhs.nim,
            mhs.nama_mahasiswa,
            jp.jenis_permohonan,
            ip.instansi_pendidikan,
            COALESCE(ps.status_persetujuan, "MENUNGGU") as status_persetujuan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->where('pm.posting_data', 'kirim');
        $builder->orderBy('pm.created_at', 'DESC');

        $data = [
            'title'       => 'Riwayat Permohonan',
            'active_menu' => 'riwayat',
            'permohonan'  => $builder->get()->getResult(),
        ];

        return view('dashboard/sekretariat/v_riwayat', $data);
    }
}
