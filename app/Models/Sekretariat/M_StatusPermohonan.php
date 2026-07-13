<?php
/**
 * ============================================================
 * Kode      : M_StatusPermohonan.php
 * Path      : Models/Sekretariat/M_StatusPermohonan.php
 * Deskripsi : Model untuk mengelola data status permohonan magang
 *             beserta tracking status verifikasi, disposisi, dan penempatan
 * ============================================================
 */

namespace App\Models\Sekretariat;

use CodeIgniter\Model;

class M_StatusPermohonan extends Model
{
    protected $table            = 't_permohonan_magang';
    protected $primaryKey       = 'id_permohonan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_mahasiswa',
        'id_instansi_mahasiswa',
        'id_jenis_permohonan',
        'deskripsi_keahlian',
        'deskripsi_magang',
        'tgl_mulai',
        'tgl_selesai',
        'posting_data',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil semua data permohonan yang sudah dikirim (posting_data='kirim')
     * dengan informasi mahasiswa, jenis permohonan, status verifikasi,
     * disposisi bidang, dan status penempatan.
     *
     * @return array
     */
    public function getAllPermohonan(): array
    {
        $builder = $this->db->table('t_permohonan_magang AS pm');

        $builder->select([
            'pm.id_permohonan_magang',
            'pm.id_mahasiswa',
            'pm.deskripsi_keahlian',
            'pm.deskripsi_magang',
            'pm.tgl_mulai',
            'pm.tgl_selesai',
            'pm.posting_data',
            'pm.created_at',
            'm.nim',
            'm.nama_mahasiswa',
            'm.jenis_kelamin',
            'm.email',
            'm.no_telp',
            'jp.jenis_permohonan',
            'ps.id_persetujuan_magang',
            'ps.status_persetujuan',
            'ps.catatan AS catatan_persetujuan',
            'ps.disposisi',
            'ps.id_bidang',
            'ps.tgl_persetujuan',
            'pn.id_penempatan_magang',
            'pn.status_penempatan',
            'COALESCE(b.bidang, b2.bidang) AS bidang',
        ]);

        $builder->join('m_mahasiswa AS m', 'm.id_mahasiswa = pm.id_mahasiswa', 'left');
        $builder->join('m_jenis_permohonan AS jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left');
        $builder->join('t_persetujuan_magang AS ps', 'ps.id_permohonan_magang = pm.id_permohonan_magang', 'left');
        // JOIN penempatan melalui id_persetujuan_magang ATAU id_mahasiswa
        $builder->join('t_penempatan_magang AS pn', 'pn.id_persetujuan_magang = ps.id_persetujuan_magang OR (pn.id_mahasiswa = pm.id_mahasiswa AND pn.id_persetujuan_magang = ps.id_persetujuan_magang)', 'left');
        // Bidang dari persetujuan (disposisi)
        $builder->join('m_bidang AS b', 'b.id_bidang = ps.id_bidang', 'left');
        // Bidang dari penempatan (jika berbeda)
        $builder->join('m_bidang AS b2', 'b2.id_bidang = pn.id_bidang', 'left');

        $builder->where('pm.posting_data', 'kirim');
        $builder->orderBy('pm.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }
}
