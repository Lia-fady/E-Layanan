<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_FilePermohonan_SuperAdmin extends Model
{
    protected $table            = 'm_file_permohonan';
    protected $primaryKey       = 'id_file_permohonan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_file_permohonan', 'id_file', 'id_jenis_permohonan', 'status_aktif'];

    /**
     * Mengambil data file permohonan lengkap dengan nama file dan jenis permohonan
     */
    public function getAllWithRelations($id = null)
    {
        $builder = $this->db->table($this->table)
            ->select('m_file_permohonan.*, m_file.nama_file, m_jenis_permohonan.jenis_permohonan')
            ->join('m_file', 'm_file.id_file = m_file_permohonan.id_file', 'left')
            ->join('m_jenis_permohonan', 'm_jenis_permohonan.id_jenis_permohonan = m_file_permohonan.id_jenis_permohonan', 'left')
            ->orderBy('m_jenis_permohonan.id_jenis_permohonan', 'ASC')
            ->orderBy('m_file_permohonan.id_file_permohonan', 'ASC');

        if ($id !== null) {
            return $builder->where('m_file_permohonan.' . $this->primaryKey, $id)->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }
}
