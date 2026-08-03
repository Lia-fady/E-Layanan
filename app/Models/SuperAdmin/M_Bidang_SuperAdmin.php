<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Bidang_SuperAdmin extends Model
{
    protected $table            = 'm_bidang';
    protected $primaryKey       = 'id_bidang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_bidang', 'id_opd', 'bidang', 'status_aktif'];

    public function getAllWithRelations()
    {
        return $this->db->table($this->table)
            ->select('m_bidang.*, m_opd.opd')
            ->join('m_opd', 'm_opd.id_opd = m_bidang.id_opd', 'left')
            ->orderBy('m_opd.opd', 'ASC')
            ->orderBy('m_bidang.bidang', 'ASC')
            ->get()->getResultArray();
    }
}
