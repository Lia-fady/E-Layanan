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
    protected $allowedFields    = ['id_instansi_pendidikan', 'id_jenjang_pendidikan', 'nama_jurusan', 'status'];

    public function getAllJurusan()
    {
        return $this->db->table($this->table)
            ->select('m_jurusan.*, m_jenjang_pendidikan.nama_jenjang, m_instansi_pendidikan.instansi_pendidikan')
            ->join('m_jenjang_pendidikan', 'm_jenjang_pendidikan.id_jenjang_pendidikan = m_jurusan.id_jenjang_pendidikan', 'left')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = m_jurusan.id_instansi_pendidikan', 'left')
            ->orderBy('m_instansi_pendidikan.instansi_pendidikan', 'ASC')
            ->orderBy('m_jurusan.nama_jurusan', 'ASC')
            ->get()->getResultArray();
    }
}
