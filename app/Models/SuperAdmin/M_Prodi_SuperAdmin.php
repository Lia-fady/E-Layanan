<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Prodi_SuperAdmin extends Model
{
    protected $table            = 'm_prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_prodi', 'id_fakultas', 'prodi', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllWithRelations()
    {
        return $this->db->table($this->table)
            ->select('m_prodi.*, m_fakultas.fakultas')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = m_prodi.id_fakultas', 'left')
            ->orderBy('m_fakultas.fakultas', 'ASC')
            ->orderBy('m_prodi.prodi', 'ASC')
            ->get()->getResultArray();
    }
}
