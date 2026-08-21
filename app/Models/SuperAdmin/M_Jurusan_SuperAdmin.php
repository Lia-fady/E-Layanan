<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Jurusan_SuperAdmin extends Model
{
    protected $table            = 'm_jurusan';
    protected $primaryKey       = 'id_jurusan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_jenjang_pendidikan', 'nama_jurusan', 'status'];

    public function getAllJurusan()
    {
        return $this->db->table($this->table)
            ->select('m_jurusan.*, m_jenjang_pendidikan.jenjang_pendidikan')
            ->join('m_jenjang_pendidikan', 'm_jenjang_pendidikan.id_jenjang_pendidikan = m_jurusan.id_jenjang_pendidikan', 'left')
            ->orderBy('m_jurusan.nama_jurusan', 'ASC')
            ->get()->getResultArray();
    }
}
