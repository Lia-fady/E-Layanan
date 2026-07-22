<?php
/**
 * ============================================================
 * Kode      : M_Verifikasi.php
 * Path      : Models/Sekretariat/M_Verifikasi.php
 * Deskripsi : Model untuk modul Verifikasi Administrasi.
 *             Mengelola data permohonan magang masuk,
 *             detail permohonan, file lampiran, validasi
 *             per-file, dan proses verifikasi.
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
     * Ambil semua permohonan masuk yang sudah dikirim
     * dan belum diverifikasi atau masih MENUNGGU.
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
            ip.instansi_pendidikan,
            COALESCE(ps.status_persetujuan, "MENUNGGU") as status_persetujuan
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->join('t_penempatan_magang as pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang', 'left');
        $builder->where('pm.posting_data', 'kirim');
        $builder->groupStart();
            $builder->where('ps.id_persetujuan_magang IS NULL');
            $builder->orWhere('ps.status_persetujuan', 'MENUNGGU');
            $builder->orWhere('ps.status_persetujuan', 'PERBAIKAN_BERKAS');
            $builder->orGroupStart()
                ->where('ps.status_persetujuan', 'DISETUJUI')
                ->groupStart()
                    ->where('pn.status_penempatan !=', 'SELESAI')
                    ->orWhere('pn.status_penempatan IS NULL')
                ->groupEnd()
            ->groupEnd();
        $builder->groupEnd();
        $builder->orderBy('pm.created_at', 'ASC');

        return $builder->get()->getResult();
    }

    /**
     * Ambil detail permohonan berdasarkan ID.
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
            ip.instansi_pendidikan,
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
     * Ambil daftar file untuk permohonan tertentu (termasuk status_verifikasi).
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
        $builder->join('m_file_permohonan as mfp', 'mfp.id_file_permohonan = fpm.id_file_permohonan', 'left');
        $builder->join('m_file as mf', 'mf.id_file = mfp.id_file', 'left');
        $builder->where('fpm.id_permohonan_magang', $id_permohonan);

        return $builder->get()->getResult();
    }

    /**
     * Ambil files grouped by permohonan IDs.
     */
    public function getFilesByPermohonanIds($ids)
    {
        if (empty($ids)) return [];

        $db = \Config\Database::connect();

        $builder = $db->table('t_file_permohonan_magang as fpm');
        $builder->select('
            fpm.id_file_permohonan_magang,
            fpm.id_permohonan_magang,
            fpm.nama_file as nama_file_upload,
            fpm.path_file,
            mf.nama_file as nama_file_master
        ');
        $builder->join('m_file_permohonan as mfp', 'mfp.id_file_permohonan = fpm.id_file_permohonan', 'left');
        $builder->join('m_file as mf', 'mf.id_file = mfp.id_file', 'left');
        $builder->whereIn('fpm.id_permohonan_magang', $ids);

        $results = $builder->get()->getResult();

        // Group by permohonan ID
        $grouped = [];
        foreach ($results as $row) {
            $grouped[$row->id_permohonan_magang][] = $row;
        }

        return $grouped;
    }

    /**
     * Simpan atau update data verifikasi.
     */
    public function simpanVerifikasi($data)
    {
        $db = \Config\Database::connect();

        $existing = $db->table('t_persetujuan_magang')
            ->where('id_permohonan_magang', $data['id_permohonan_magang'])
            ->get()
            ->getRow();

        if ($existing) {
            return $db->table('t_persetujuan_magang')
                ->where('id_permohonan_magang', $data['id_permohonan_magang'])
                ->update([
                    'catatan'             => $data['catatan'],
                    'status_persetujuan'  => $data['status_persetujuan'],
                    'updated_by'          => $data['updated_by'],
                    'tgl_persetujuan'     => date('Y-m-d H:i:s'),
                ]);
        } else {
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

    /**
     * Kembalikan permohonan (set DITOLAK).
     */
    public function kembalikanPermohonan($id_permohonan)
    {
        $db = \Config\Database::connect();

        $existing = $db->table('t_persetujuan_magang')
            ->where('id_permohonan_magang', $id_permohonan)
            ->get()
            ->getRow();

        if ($existing) {
            return $db->table('t_persetujuan_magang')
                ->where('id_permohonan_magang', $id_permohonan)
                ->update([
                    'status_persetujuan' => 'PERBAIKAN_BERKAS',
                    'catatan'            => 'Berkas dikembalikan',
                    'tgl_persetujuan'    => date('Y-m-d H:i:s'),
                ]);
        } else {
            return $db->table('t_persetujuan_magang')
                ->insert([
                    'id_permohonan_magang' => $id_permohonan,
                    'status_persetujuan'   => 'PERBAIKAN_BERKAS',
                    'catatan'              => 'Berkas dikembalikan',
                    'disposisi'            => '0',
                    'tgl_persetujuan'      => date('Y-m-d H:i:s'),
                ]);
        }
    }
}
