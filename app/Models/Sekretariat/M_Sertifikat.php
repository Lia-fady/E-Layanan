<?php
/**
 * ============================================================
 * Kode      : M_Sertifikat.php
 * Path      : Models/Sekretariat/M_Sertifikat.php
 * Deskripsi : Model untuk mengelola data sertifikat magang,
 *             mengambil data penempatan yang sudah selesai dan
 *             data lengkap untuk pembuatan sertifikat
 * ============================================================
 */

namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_Sertifikat extends Model
{
    protected $table            = 't_penempatan_magang';
    protected $primaryKey       = 'id_penempatan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
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
     * Mengambil data penempatan magang yang sudah selesai
     * untuk ditampilkan di daftar sertifikat.
     *
     * @return array
     */
    public function getMagangSelesai(): array
    {
        $builder = $this->db->table('t_penempatan_magang AS pn');

        $builder->select([
            'pn.id_penempatan_magang',
            'm.nim',
            'm.nama_mahasiswa',
            'b.bidang',
            'pm.tgl_mulai',
            'pm.tgl_selesai',
        ]);

        $builder->join('m_mahasiswa AS m', 'm.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang AS b', 'b.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang AS ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang AS pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');

        $builder->where('pn.status_penempatan', 'SELESAI');
        $builder->orderBy('pm.tgl_selesai', 'DESC');

        return $builder->get()->getResultArray();
    }

    /**
     * Mengambil data lengkap untuk pembuatan sertifikat.
     * Termasuk data mahasiswa, bidang, periode magang,
     * instansi pendidikan, dan program studi.
     *
     * @param int $id_penempatan
     * @return array|null
     */
    public function getDataSertifikat($id_penempatan)
    {
        $builder = $this->db->table('t_penempatan_magang AS pn');

        $builder->select([
            'pn.id_penempatan_magang',
            'pn.status_penempatan',
            'm.id_mahasiswa',
            'm.nim',
            'm.nama_mahasiswa',
            'm.jenis_kelamin',
            'm.email',
            'm.no_telp',
            'b.bidang',
            'ps.status_persetujuan',
            'ps.tgl_persetujuan',
            'pm.id_permohonan_magang',
            'pm.tgl_mulai',
            'pm.tgl_selesai',
            'pm.deskripsi_keahlian',
            'pm.deskripsi_magang',
            'ip.instansi_pendidikan',
            'ip.jenis_instansi',
            'pr.prodi',
        ]);

        $builder->join('m_mahasiswa AS m', 'm.id_mahasiswa = pn.id_mahasiswa', 'left');
        $builder->join('m_bidang AS b', 'b.id_bidang = pn.id_bidang', 'left');
        $builder->join('t_persetujuan_magang AS ps', 'ps.id_persetujuan_magang = pn.id_persetujuan_magang', 'left');
        $builder->join('t_permohonan_magang AS pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left');
        $builder->join('t_instansi_mahasiswa AS im', 'im.id_mahasiswa = m.id_mahasiswa', 'left');
        $builder->join('m_instansi_pendidikan AS ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left');
        $builder->join('m_prodi AS pr', 'pr.id_prodi = im.id_prodi', 'left');

        $builder->where('pn.id_penempatan_magang', $id_penempatan);

        return $builder->get()->getRowArray();
    }

    /**
     * Mengambil data penilaian magang berdasarkan id penempatan.
     * Digunakan untuk mencantumkan nilai pada sertifikat.
     *
     * @param int $id_penempatan
     * @return array
     */
    public function getNilaiByPenempatan($id_penempatan): array
    {
        $builder = $this->db->table('t_penilaian_magang AS pnl');

        $builder->select([
            'pnl.id_penilaian_magang',
            'pnl.nilai',
            'kp.komponen_penilaian',
        ]);

        $builder->join('m_komponen_penilaian AS kp', 'kp.id_komponen_penilaian = pnl.id_komponen_penilaian', 'left');
        $builder->where('pnl.id_penempatan_magang', $id_penempatan);
        $builder->orderBy('kp.komponen_penilaian', 'ASC');

        return $builder->get()->getResultArray();
    }
}
