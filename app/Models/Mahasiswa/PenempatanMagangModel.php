<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class PenempatanMagangModel extends Model
{
    protected $table            = 't_penempatan_magang';
    protected $primaryKey       = 'id_penempatan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Mempertahankan fields asli bawaan kelompokmu untuk insert/update
    protected $allowedFields    = [
        'id_bidang',
        'id_persetujuan_magang',
        'id_mahasiswa',
        'catatan',
        'status_penempatan', // BERJALAN, SELESAI, DIBATALKAN
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'is_log_book'
    ];

    /**
     * TAMBAHAN FITUR: Mengambil detail penempatan beserta nama bidang untuk modul sertifikat
     */
    public function getPenempatanDetail($id_mahasiswa)
    {
        return $this->db->table($this->table)
            ->select('t_penempatan_magang.*, m_bidang.bidang')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_persetujuan_magang = t_penempatan_magang.id_persetujuan_magang')
            ->join('t_permohonan_magang', 't_permohonan_magang.id_permohonan_magang = t_persetujuan_magang.id_permohonan_magang')
            ->join('m_bidang', 'm_bidang.id_bidang = t_persetujuan_magang.id_bidang', 'left')
            ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();
    }

}
