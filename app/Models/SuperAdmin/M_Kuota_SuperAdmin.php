<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Kuota_SuperAdmin extends Model
{
    protected $table            = 'm_kuota';
    protected $primaryKey       = 'id_kuota';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kuota', 'id_bidang', 'kuota', 'status_aktif'];

    public function getAllWithRelations()
    {
        return $this->db->table($this->table)
            ->select('m_kuota.*, m_bidang.bidang')
            ->join('m_bidang', 'm_bidang.id_bidang = m_kuota.id_bidang', 'left')
            ->orderBy('m_bidang.bidang', 'ASC')
            ->get()->getResultArray();
    }
}
