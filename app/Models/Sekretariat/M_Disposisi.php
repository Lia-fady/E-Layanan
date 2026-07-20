<?php
/**
 * ============================================================
 * Kode      : M_Disposisi.php
 * Path      : Models/Sekretariat/M_Disposisi.php
 * Deskripsi : Model untuk modul Disposisi Bidang.
 *             Mengelola data permohonan yang sudah disetujui
 *             untuk didisposisikan ke bidang terkait,
 *             termasuk pengecekan kuota bidang.
 * ============================================================
 */

namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_Disposisi extends Model
{
    protected $table            = 't_persetujuan_magang';
    protected $primaryKey       = 'id_persetujuan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [];

    /**
     * Ambil semua permohonan yang sudah disetujui verifikasinya
     * dan belum didisposisikan (disposisi = '0' atau NULL).
     *
     * @return array
     */
    public function getPermohonanDisetujui()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_persetujuan_magang as ps');
        $builder->select('
            ps.id_persetujuan_magang,
            ps.id_permohonan_magang,
            ps.status_persetujuan,
            ps.disposisi,
            ps.id_bidang,
            ps.tgl_persetujuan,
            pm.deskripsi_keahlian,
            pm.deskripsi_magang,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.created_at as tgl_pengajuan,
            mhs.nim,
            mhs.nama_mahasiswa,
            jp.jenis_permohonan
        ');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->where('ps.status_persetujuan', 'DISETUJUI');
        $builder->groupStart();
            $builder->where('ps.disposisi', '0');
            $builder->orWhere('ps.disposisi IS NULL');
        $builder->groupEnd();
        $builder->orderBy('ps.tgl_persetujuan', 'DESC');

        return $builder->get()->getResult();
    }

    /**
     * Ambil detail persetujuan berdasarkan ID dengan semua relasi.
     *
     * @param int $id_persetujuan
     * @return object|null
     */
    public function getDisposisiById($id_persetujuan)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_persetujuan_magang as ps');
        $builder->select('
            ps.*,
            pm.id_permohonan_magang,
            pm.deskripsi_keahlian,
            pm.deskripsi_magang,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.created_at as tgl_pengajuan,
            mhs.nim,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.email,
            mhs.no_telp,
            jp.jenis_permohonan,
            im.jenjang_pendidikan,
            ip.instansi_pendidikan,
            pr.prodi,
            fk.fakultas,
            bd.bidang
        ');
        $builder->join('t_permohonan_magang as pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');
        $builder->join('m_fakultas as fk', 'fk.id_fakultas = pr.id_fakultas', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = ps.id_bidang', 'left');
        $builder->where('ps.id_persetujuan_magang', $id_persetujuan);

        return $builder->get()->getRow();
    }

    /**
     * Ambil semua bidang yang aktif.
     *
     * @return array
     */
    public function getBidangAktif()
    {
        $db = \Config\Database::connect();

        return $db->table('m_bidang')
            ->where('status_aktif', 'aktif')
            ->get()
            ->getResult();
    }

    /**
     * Ambil kuota bidang berdasarkan id_bidang.
     *
     * @param int $id_bidang
     * @return object|null
     */
    public function getKuotaBidang($id_bidang)
    {
        $db = \Config\Database::connect();

        return $db->table('m_kuota')
            ->where('id_bidang', $id_bidang)
            ->where('status_aktif', '1')
            ->get()
            ->getRow();
    }

    /**
     * Simpan disposisi ke bidang.
     * Update record t_persetujuan_magang dengan data disposisi.
     *
     * @param int   $id_persetujuan
     * @param array $data
     * @return bool
     */
    public function simpanDisposisi($id_persetujuan, $data)
    {
        $db = \Config\Database::connect();

        // 1. Update t_persetujuan_magang dengan data disposisi
        $result = $db->table('t_persetujuan_magang')
            ->where('id_persetujuan_magang', $id_persetujuan)
            ->update([
                'disposisi'       => '1',
                'id_bidang'       => $data['id_bidang'],
                'updated_by'      => $data['updated_by'],
                'updated_at'      => date('Y-m-d H:i:s'),
                'tgl_persetujuan' => date('Y-m-d H:i:s'),
            ]);

        if (!$result) {
            return false;
        }

        // 2. Ambil id_mahasiswa dari relasi persetujuan → permohonan
        $persetujuan = $db->table('t_persetujuan_magang')
            ->where('id_persetujuan_magang', $id_persetujuan)
            ->get()
            ->getRow();

        if (!$persetujuan) {
            return false;
        }

        $permohonan = $db->table('t_permohonan_magang')
            ->where('id_permohonan_magang', $persetujuan->id_permohonan_magang)
            ->get()
            ->getRow();

        if (!$permohonan) {
            return false;
        }

        // 3. Insert record ke t_penempatan_magang dengan status MENUNGGU
        $db->table('t_penempatan_magang')->insert([
            'id_bidang'             => $data['id_bidang'],
            'id_persetujuan_magang' => $id_persetujuan,
            'id_mahasiswa'          => $permohonan->id_mahasiswa,
            'catatan'               => $data['catatan_disposisi'] ?? null,
            'status_penempatan'     => 'MENUNGGU',
            'created_by'            => $data['updated_by'],
            'created_at'            => date('Y-m-d H:i:s'),
        ]);

        return true;
    }
}
