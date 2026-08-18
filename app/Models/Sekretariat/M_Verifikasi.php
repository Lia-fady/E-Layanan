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
    protected $allowedFields    = ['id_mahasiswa', 'id_instansi_mahasiswa', 'id_jenis_permohonan', 'tujuan', 'deskripsi_keahlian', 'rencana_kegiatan', 'tgl_mulai', 'tgl_selesai', 'posting_data', 'created_at', 'created_by', 'updated_by', 'deleted_at'];
    protected $useSoftDeletes   = true;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';
    protected $deletedField  = 'deleted_at';


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
            pm.rencana_kegiatan,
            pm.tgl_mulai,
            pm.tgl_selesai,
            pm.posting_data,
            pm.created_at as tgl_pengajuan,
            mhs.nim,
            mhs.nama_mahasiswa,
            jp.jenis_permohonan,
            ip.instansi_pendidikan,
            COALESCE(ps.status_persetujuan, "MENUNGGU") as status_persetujuan,
            pn.status_penempatan,
            bd.bidang as nama_bidang
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('t_persetujuan_magang as ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        $builder->join('t_penempatan_magang as pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang', 'left');
        $builder->join('m_bidang as bd', 'bd.id_bidang = pn.id_bidang', 'left');
        $builder->where('pm.posting_data', 'kirim');
        $builder->groupStart();
            $builder->where('ps.id_persetujuan_magang IS NULL');
            $builder->orWhere('ps.status_persetujuan', 'MENUNGGU');
        $builder->groupEnd();
        $builder->orderBy('pm.created_at', 'ASC');

        $results = $builder->get()->getResult();

        foreach ($results as $row) {
            $status_pers = strtoupper($row->status_persetujuan ?? 'MENUNGGU');
            $has_bidang = !empty($row->nama_bidang);
            
            if ($status_pers === 'DITOLAK') {
                $row->badge_penempatan = 'badge badge-secondary';
                $row->label_penempatan = 'Tidak Ada Penempatan';
                $row->bidang_display   = '-';
            } elseif ($status_pers === 'PERBAIKAN_BERKAS') {
                $row->badge_penempatan = 'badge badge-secondary';
                $row->label_penempatan = 'Berkas Dikembalikan';
                $row->bidang_display   = '-';
            } elseif ($status_pers === 'MENUNGGU') {
                $row->badge_penempatan = 'badge badge-secondary';
                $row->label_penempatan = 'Belum Diverifikasi';
                $row->bidang_display   = '-';
            } elseif ($status_pers === 'DISETUJUI' && !$has_bidang) {
                $row->badge_penempatan = 'badge badge-secondary';
                $row->label_penempatan = 'Penempatan Belum Ditentukan';
                $row->bidang_display   = 'Bidang Belum Ditentukan';
            } else {
                $raw_status_pn = !empty($row->status_penempatan) ? strtoupper($row->status_penempatan) : 'MENUNGGU';
                $row->bidang_display = $has_bidang ? $row->nama_bidang : 'Belum Ditentukan';
                
                $row->badge_penempatan = 'badge badge-warning';
                $row->label_penempatan = 'Menunggu Persetujuan Bidang';

                if ($raw_status_pn == 'BERJALAN') {
                    $row->badge_penempatan = 'badge badge-info';
                    $row->label_penempatan = 'Disetujui Oleh Bidang';
                } elseif ($raw_status_pn == 'DIBATALKAN') {
                    $row->badge_penempatan = 'badge badge-danger';
                    $row->label_penempatan = 'Tidak Disetujui Oleh Bidang';
                } elseif ($raw_status_pn == 'SELESAI') {
                    $row->badge_penempatan = 'badge badge-success';
                    $row->label_penempatan = 'SELESAI';
                } elseif ($raw_status_pn != 'MENUNGGU') {
                    $row->label_penempatan = esc($raw_status_pn);
                }
            }
        }

        return $results;
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
            mhs.nik,
            mhs.nim,
            mhs.nama_mahasiswa,
            mhs.jenis_kelamin,
            mhs.tgl_lahir,
            mhs.alamat,
            mhs.rt,
            mhs.rw,
            mhs.no_telp,
            mhs.email,
            jp.jenis_permohonan,
            jn.nama_jenjang AS jenjang_pendidikan,
            ip.instansi_pendidikan,
            COALESCE(pr.nama_prodi, im.jurusan) AS nama_prodi,
            fk.fakultas AS nama_fakultas,
            im.semester,
            im.angkatan_tahun,
            kls.nama_kelas AS kelas,
            COALESCE(ps.status_persetujuan, "MENUNGGU") as status_persetujuan,
            ps.catatan,
            ps.id_persetujuan_magang,
            ps.disposisi,
            m_kelurahan.nama_kelurahan as kelurahan,
            m_kecamatan.nama_kecamatan as kecamatan,
            m_kabupaten.nama_kabupaten as kabupaten_kota,
            m_provinsi.nama_provinsi as provinsi
        ');
        $builder->join('m_mahasiswa as mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_kelurahan', 'm_kelurahan.id_kelurahan = mhs.id_kelurahan', 'left');
        $builder->join('m_kecamatan', 'm_kecamatan.id_kecamatan = m_kelurahan.id_kecamatan', 'left');
        $builder->join('m_kabupaten', 'm_kabupaten.id_kabupaten = m_kecamatan.id_kabupaten', 'left');
        $builder->join('m_provinsi', 'm_provinsi.id_provinsi = m_kabupaten.id_provinsi', 'left');
        $builder->join('m_jenis_permohonan as jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_instansi_mahasiswa as im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan as ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi as pr', 'pr.id_prodi = im.id_prodi', 'left');
        $builder->join('m_fakultas as fk', 'fk.id_fakultas = pr.id_fakultas', 'left');
        $builder->join('m_kelas as kls', 'kls.id_kelas = im.id_kelas', 'left');
        $builder->join('m_jenjang_pendidikan as jn', 'jn.id_jenjang_pendidikan = im.id_jenjang_pendidikan', 'left');
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
            fpm.status_verifikasi,
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
            // Guard: Jangan izinkan update jika keputusan sudah pernah disimpan
            // Status selain MENUNGGU berarti keputusan sudah final
            if ($existing->status_persetujuan !== 'MENUNGGU') {
                return false;
            }

            $updateData = [
                'catatan'             => $data['catatan'],
                'status_persetujuan'  => $data['status_persetujuan'],
                'updated_by'          => $data['updated_by'],
                'tanggal_persetujuan'     => date('Y-m-d H:i:s'),
            ];

            if ($data['status_persetujuan'] === 'PERBAIKAN_BERKAS' || $data['status_persetujuan'] === 'MENUNGGU') {
                $updateData['disposisi'] = 'BELUM';
                $updateData['id_bidang'] = null;
            }

            return $db->table('t_persetujuan_magang')
                ->where('id_permohonan_magang', $data['id_permohonan_magang'])
                ->update($updateData);
        } else {
            return $db->table('t_persetujuan_magang')
                ->insert([
                    'id_permohonan_magang' => $data['id_permohonan_magang'],
                    'catatan'              => $data['catatan'],
                    'status_persetujuan'   => $data['status_persetujuan'],
                    'created_by'           => $data['created_by'],
                    'updated_by'           => $data['updated_by'],
                    'disposisi'            => 'BELUM',
                    'tanggal_persetujuan'      => date('Y-m-d H:i:s'),
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
                    'disposisi'          => 'BELUM',
                    'id_bidang'          => null,
                    'tanggal_persetujuan'    => date('Y-m-d H:i:s'),
                ]);
        } else {
            return $db->table('t_persetujuan_magang')
                ->insert([
                    'id_permohonan_magang' => $id_permohonan,
                    'status_persetujuan'   => 'PERBAIKAN_BERKAS',
                    'catatan'              => 'Berkas dikembalikan',
                    'disposisi'            => 'BELUM',
                    'tanggal_persetujuan'      => date('Y-m-d H:i:s'),
                ]);
        }
    }
}
