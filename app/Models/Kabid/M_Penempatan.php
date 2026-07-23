<?php
/**
 * ============================================================
 * Kode      : M_Penempatan.php
 * Path      : Models/Kabid/M_Penempatan.php
 * Deskripsi : Model untuk modul Persetujuan Penempatan Kepala Bidang.
 *             Mengelola data penempatan magang yang menunggu
 *             persetujuan Kepala Bidang, termasuk setujui dan tolak.
 * ============================================================
 */

namespace App\Models\Kabid;

use CodeIgniter\Model;

class M_Penempatan extends Model
{
    protected $table            = 't_penempatan_magang';
    protected $primaryKey       = 'id_penempatan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [
        'id_bidang',
        'id_persetujuan_magang',
        'id_mahasiswa',
        'catatan',
        'status_penempatan',
        'created_by',
        'updated_by',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil daftar penempatan dengan status MENUNGGU
     * untuk bidang tertentu (berdasarkan id_bidang Kepala Bidang).
     *
     * @param int|null $id_bidang  Jika null, tampilkan semua
     * @return array
     */
    public function getPenempatanMenunggu($id_bidang = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_penempatan_magang as pn');
        $builder->select('
            pn.id_penempatan_magang,
            pn.id_bidang,
            pn.id_persetujuan_magang,
            pn.id_mahasiswa,
            pn.catatan,
            pn.status_penempatan,
            pn.created_at,
            mhs.nim,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.email,
            mhs.no_telp,
            bd.bidang,
            pm.deskripsi_keahlian,
            pm.deskripsi_magang,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.created_at as tgl_pengajuan,
            jp.jenis_permohonan,
            ip.instansi_pendidikan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->where('pn.status_penempatan', 'MENUNGGU');

        if ($id_bidang !== null) {
            $builder->where('pn.id_bidang', $id_bidang);
        }

        $builder->orderBy('pn.created_at', 'DESC');

        return $builder->get()->getResult();
    }

    /**
     * Ambil detail penempatan berdasarkan ID.
     *
     * @param int $id_penempatan
     * @return object|null
     */
    public function getDetailPenempatan($id_penempatan)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_penempatan_magang as pn');
        $builder->select('
            pn.*,
            mhs.nim,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.email,
            mhs.no_telp,
            bd.bidang,
            pm.deskripsi_keahlian,
            pm.deskripsi_magang,
            pm.tgl_mulai,
            pm.tgl_selesai,
            jp.jenis_permohonan,
            ip.instansi_pendidikan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->where('pn.id_penempatan_magang', $id_penempatan);

        return $builder->get()->getRow();
    }

    /**
     * Setujui penempatan: update status ke BERJALAN.
     *
     * @param int $id_penempatan
     * @param int $updated_by
     * @return bool
     */
    public function setujuiPenempatan($id_penempatan, $updated_by)
    {
        $db = \Config\Database::connect();

        return $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'BERJALAN',
                'updated_by'        => $updated_by,
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Tolak penempatan:
     * 1. Hapus record dari t_penempatan_magang
     * 2. Reset disposisi di t_persetujuan_magang (disposisi = '0', id_bidang = NULL)
     *    agar permohonan muncul kembali di halaman Disposisi Sekretariat.
     *
     * @param int    $id_penempatan
     * @param string $catatan
     * @param int    $updated_by
     * @return bool
     */
    public function tolakPenempatan($id_penempatan, $catatan, $updated_by)
    {
        $db = \Config\Database::connect();

        // Ambil data penempatan untuk mendapatkan id_persetujuan_magang
        $penempatan = $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->get()
            ->getRow();

        if (!$penempatan) {
            return false;
        }

        // 1. Hapus record penempatan
        $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->delete();

        // 2. Reset disposisi di t_persetujuan_magang agar muncul kembali di halaman Disposisi
        $db->table('t_persetujuan_magang')
            ->where('id_persetujuan_magang', $penempatan->id_persetujuan_magang)
            ->update([
                'disposisi'  => '0',
                'id_bidang'  => null,
                'updated_by' => $updated_by,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        return true;
    }

    /**
     * Hitung jumlah penempatan menunggu untuk bidang tertentu.
     *
     * @param int|null $id_bidang
     * @return int
     */
    public function countPenempatanMenunggu($id_bidang = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_penempatan_magang');
        $builder->where('status_penempatan', '0');

        if ($id_bidang !== null) {
            $builder->where('id_bidang', $id_bidang);
        }

        return $builder->countAllResults();
    }
}
