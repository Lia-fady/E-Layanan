<?php
/**
 * ============================================================
 * Kode      : M_Verifikasi.php
 * Path      : Models/Sekretariat/M_Verifikasi.php
 * Deskripsi : Model untuk modul Verifikasi Administrasi.
 *             Mengelola data permohonan magang masuk,
 *             detail permohonan, file lampiran, dan
 *             proses verifikasi (setuju/tolak).
 * ============================================================
 */

namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_Verifikasi extends Model
{
    protected $table            = 't_permohonan_magang';
    protected $primaryKey       = 'id_permohonan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = [];

    /**
     * Ambil semua permohonan masuk yang sudah dikirim (posting_data = 'kirim')
     * dan belum diverifikasi (tidak ada record di t_persetujuan_magang)
     * atau masih berstatus MENUNGGU.
     *
     * @return array
     */
    public function getPermohonanMasuk()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_permohonan_magang as pm');
        $builder->select('
            pm.id_permohonan_magang,
            pm.deskripsi_keahlian,
            pm.deskripsi_magang,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.posting_data,
            pm.created_at as tgl_pengajuan,
            mhs.nim,
            mhs.nama_mahasiswa,
            jp.jenis_permohonan,
            COALESCE(ps.status_persetujuan, "MENUNGGU") as status_persetujuan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->where('pm.posting_data', 'kirim');
        $builder->groupStart();
            $builder->where('ps.id_persetujuan_magang IS NULL');
            $builder->orWhere('ps.status_persetujuan', 'MENUNGGU');
        $builder->groupEnd();
        $builder->orderBy('pm.created_at', 'DESC');

        return $builder->get()->getResult();
    }

    /**
     * Ambil detail permohonan berdasarkan ID dengan semua relasi.
     *
     * @param int $id
     * @return object|null
     */
    public function getPermohonanById($id)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_permohonan_magang as pm');
        $builder->select('
            pm.*,
            mhs.nim,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.tgl_lahir,
            mhs.alamat,
            mhs.no_telp,
            mhs.email,
            jp.jenis_permohonan,
            im.jenjang_pendidikan,
            im.angkatan_tahun,
            im.semester,
            im.tahun_akademik,
            ip.instansi_pendidikan,
            ip.jenis_instansi,
            pr.prodi,
            fk.fakultas,
            COALESCE(ps.status_persetujuan, "MENUNGGU") as status_persetujuan,
            ps.catatan,
            ps.id_persetujuan_magang
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');
        $builder->join('m_fakultas as fk', 'fk.id_fakultas = pr.id_fakultas', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->where('pm.id_permohonan_magang', $id);

        return $builder->get()->getRow();
    }

    /**
     * Ambil daftar file yang diupload untuk permohonan tertentu.
     *
     * @param int $id_permohonan
     * @return array
     */
    public function getFilePermohonan($id_permohonan)
    {
        $db = \Config\Database::connect();

        $builder = $db->table('t_file_permohonan_magang as fpm');
        $builder->select('
            fpm.id_file_permohonan_magang,
            fpm.id_permohonan_magang,
            fpm.nama_file as nama_file_upload,
            fpm.path_file,
            fpm.created_at,
            mf.nama_file as nama_file_master
        ');
        $builder->join('m_file as mf', 'mf.id_file = fpm.id_file', 'left');
        $builder->where('fpm.id_permohonan_magang', $id_permohonan);

        return $builder->get()->getResult();
    }

    /**
     * Simpan atau update data verifikasi permohonan.
     * Jika sudah ada record untuk id_permohonan_magang, lakukan update.
     * Jika belum, lakukan insert.
     *
     * @param array $data
     * @return bool
     */
    public function simpanVerifikasi($data)
    {
        $db = \Config\Database::connect();

        // Cek apakah sudah ada record verifikasi untuk permohonan ini
        $existing = $db->table('t_persetujuan_magang')
            ->where('id_permohonan_magang', $data['id_permohonan_magang'])
            ->get()
            ->getRow();

        if ($existing) {
            // Update record yang sudah ada
            return $db->table('t_persetujuan_magang')
                ->where('id_permohonan_magang', $data['id_permohonan_magang'])
                ->update([
                    'catatan'             => $data['catatan'],
                    'status_persetujuan'  => $data['status_persetujuan'],
                    'updated_by'          => $data['updated_by'],
                    'tgl_persetujuan'     => date('Y-m-d H:i:s'),
                ]);
        } else {
            // Insert record baru
            return $db->table('t_persetujuan_magang')
                ->insert([
                    'id_permohonan_magang' => $data['id_permohonan_magang'],
                    'catatan'              => $data['catatan'],
                    'status_persetujuan'   => $data['status_persetujuan'],
                    'created_by'           => $data['created_by'],
                    'updated_by'           => $data['updated_by'],
                    'disposisi'            => '0',
                    'tgl_persetujuan'      => date('Y-m-d H:i:s'),
                ]);
        }
    }
}
