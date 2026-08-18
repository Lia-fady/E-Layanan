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
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Ambil daftar penempatan untuk bidang tertentu.
     *
     * @param int|null $id_bidang  Jika null, tampilkan semua
     * @param string|null $status_penempatan  Jika diset, filter berdasarkan status tertentu
     * @return array
     */
    public function getSemuaPenempatan($id_bidang = null, $status_penempatan = null)
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
            mhs.tgl_lahir,
            im.semester,
            im.angkatan_tahun,
            im.id_jenjang_pendidikan,
            kls.nama_kelas as kelas,
            jur.nama_jurusan as jurusan,
            jnj.nama_jenjang as jenjang_pendidikan,
            pm.id_jenis_permohonan,
            bd.bidang,
            pm.deskripsi_keahlian,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.created_at as tgl_pengajuan,
            jp.jenis_permohonan,
            ip.instansi_pendidikan,
            pr.nama_prodi as prodi,
            ps.catatan as catatan_sekretariat
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');
        $builder->join('m_jurusan as jur', 'jur.id_jurusan = im.id_jurusan', 'left');
        $builder->join('m_kelas as kls', 'kls.id_kelas = im.id_kelas', 'left');
        $builder->join('m_jenjang_pendidikan as jnj', 'jnj.id_jenjang_pendidikan = im.id_jenjang_pendidikan', 'left');
        if ($id_bidang !== null) {
            $builder->where('pn.id_bidang', $id_bidang);
        }

        if ($status_penempatan !== null) {
            if (is_array($status_penempatan)) {
                $builder->whereIn('pn.status_penempatan', $status_penempatan);
            } else {
                $builder->where('pn.status_penempatan', $status_penempatan);
            }
        }

        $builder->orderBy('pn.created_at', 'ASC');

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
            mhs.nik,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.email,
            mhs.no_telp,
            mhs.tgl_lahir,
            mhs.alamat,
            mhs.rt,
            mhs.rw,
            kel.nama_kelurahan as kelurahan,
            kec.nama_kecamatan as kecamatan,
            kab.nama_kabupaten as kabupaten,
            prov.nama_provinsi as provinsi,
            im.semester,
            im.angkatan_tahun,
            im.id_jenjang_pendidikan,
            im.jurusan as jurusan_siswa,
            kls.nama_kelas as kelas,
            jur.nama_jurusan as jurusan,
            jnj.nama_jenjang as jenjang_pendidikan,
            pm.id_jenis_permohonan,
            pr.nama_prodi as prodi,
            bd.bidang,
            pm.deskripsi_keahlian,
            pm.tgl_mulai,
            pm.tgl_selesai,
            jp.jenis_permohonan,
            ip.instansi_pendidikan,
            ps.catatan as catatan_sekretariat,
            ps.tanggal_persetujuan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');
        $builder->join('m_jurusan as jur', 'jur.id_jurusan = im.id_jurusan', 'left');
        $builder->join('m_kelas as kls', 'kls.id_kelas = im.id_kelas', 'left');
        $builder->join('m_jenjang_pendidikan as jnj', 'jnj.id_jenjang_pendidikan = im.id_jenjang_pendidikan', 'left');
        $builder->join('m_kelurahan as kel', 'kel.id_kelurahan = mhs.id_kelurahan', 'left');
        $builder->join('m_kecamatan as kec', 'kec.id_kecamatan = kel.id_kecamatan', 'left');
        $builder->join('m_kabupaten as kab', 'kab.id_kabupaten = kec.id_kabupaten', 'left');
        $builder->join('m_provinsi as prov', 'prov.id_provinsi = kab.id_provinsi', 'left');
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
    public function setujuiPenempatan($id_penempatan, $is_log_book, $catatan, $updated_by)
    {
        $db = \Config\Database::connect();

        return $db->table('t_penempatan_magang')
            ->where('id_penempatan_magang', $id_penempatan)
            ->update([
                'status_penempatan' => 'BERJALAN',
                'is_log_book'       => $is_log_book,
                'catatan'           => $catatan,
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
                'catatan'           => $catatan,
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
