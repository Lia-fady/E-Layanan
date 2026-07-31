<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_UserMahasiswa extends Model
{
    protected $table            = 'm_user_mahasiswa';
    protected $primaryKey       = 'id_user_mahasiswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_user_mahasiswa', 'id_mahasiswa', 'username', 'password', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllWithRelations()
    {
        return $this->db->table($this->table)
            ->select('m_user_mahasiswa.*, m_mahasiswa.nama_mahasiswa')
            ->join('m_mahasiswa', 'm_mahasiswa.id_mahasiswa = m_user_mahasiswa.id_mahasiswa', 'left')
            ->orderBy('m_mahasiswa.nama_mahasiswa', 'ASC')
            ->get()->getResultArray();
    }
}
