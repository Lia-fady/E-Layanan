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

namespace App\Models\Bidang;

use CodeIgniter\Model;

class M_Penempatan_Bidang extends Model
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
     * Ambil daftar semua penempatan untuk bidang tertentu.
     *
     * @param int|null $id_bidang  Jika null, tampilkan semua
     * @return array
     */
    public function getSemuaPenempatan($id_bidang = null)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_penempatan_magang as pn');
        $builder->select('
            pn.id_penempatan_magang,
            pn.id_bidang,
            pn.id_persetujuan_magang,
            pm.id_permohonan_magang,
            pn.id_mahasiswa,
            pn.catatan,
            pn.status_penempatan,
            pn.is_log_book,
            pn.created_at,
            mhs.nim,
            mhs.nik,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.email,
            mhs.no_telp,
            im.semester,
            bd.bidang,
            pm.deskripsi_keahlian,
            pm.deskripsi,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.created_at as tgl_pengajuan,
            jp.jenis_permohonan,
            ip.instansi_pendidikan,
            pr.prodi
        ');
        $builder->join('M_Mahasiswa_Mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');

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
            pm.deskripsi,
            pm.tgl_mulai,
            pm.tgl_selesai,
            jp.jenis_permohonan,
            ip.instansi_pendidikan
        ');
        $builder->join('M_Mahasiswa_Mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
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
     * Setujui penempatan: update status ke BERJALAN dan set is_log_book.
     *
     * @param int $id_penempatan
     * @param string $is_log_book
     * @param int $updated_by
     * @return bool
     */
    public function setujuiPenempatan($id_penempatan, $is_log_book, $updated_by)
    {
        $db = \Config\Database::connect();

        return $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'BERJALAN',
                'is_log_book'       => $is_log_book,
                'updated_by'        => $updated_by,
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
    }

    /**
     * Tolak penempatan:
     * Ubah status menjadi DIBATALKAN (tidak dihapus).
     *
     * @param int    $id_penempatan
     * @param string $catatan
     * @param int    $updated_by
     * @return bool
     */
    public function tolakPenempatan($id_penempatan, $catatan, $updated_by)
    {
        $db = \Config\Database::connect();

        // Update status di t_penempatan_magang menjadi DIBATALKAN
        $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'DIBATALKAN',
                'updated_by'        => $updated_by,
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);

        // (Opsional) Jika perlu mengembalikan ke Sekretariat, uncomment baris bawah.
        // Sesuai permintaan "Data tetap berada pada halaman ini, hanya statusnya yang berubah menjadi Dibatalkan",
        // kita tidak perlu me-reset disposisi di t_persetujuan_magang agar tidak terduplikasi.

        return true;
    }

    /**
     * Selesaikan penempatan:
     * Ubah status menjadi SELESAI.
     *
     * @param int $id_penempatan
     * @param int $updated_by
     * @return bool
     */
    public function selesaikanPenempatan($id_penempatan, $updated_by)
    {
        $db = \Config\Database::connect();

        return $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'SELESAI',
                'updated_by'        => $updated_by,
                'updated_at'        => date('Y-m-d H:i:s'),
            ]);
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
