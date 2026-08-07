<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_PenempatanMagang extends Model
{
    protected $table            = 't_penempatan_magang';
    protected $primaryKey       = 'id_penempatan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Mempertahankan fields asli bawaan kelompokmu untuk insert/update
    protected $allowedFields    = ['id_persetujuan_magang', 'id_mahasiswa', 'id_bidang', 'tanggal_mulai', 'tanggal_selesai', 'tanggal_persetujuan', 'status_penempatan', 'is_log_book', 'catatan', 'created_at', 'updated_at'];
    protected $useSoftDeletes   = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


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
