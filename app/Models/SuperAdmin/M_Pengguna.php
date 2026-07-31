<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Pengguna extends Model
{
    protected $table            = 'c_user_pegawai';
    protected $primaryKey       = 'id_user_pegawai';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_user_pegawai', 'nama', 'nip', 'password', 'kode_unor',
        'id_user_group', 'id_bidang', 'status_aktif',
        'file_tanda_tangan', 'last_login'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Mengambil data pengguna lengkap dengan nama group
     */
    public function getAllWithGroup($id = null)
    {
        $builder = $this->db->table($this->table)
            ->select('c_user_pegawai.*, c_user_group.group AS nama_group')
            ->join('c_user_group', 'c_user_group.id = c_user_pegawai.id_user_group', 'left')
            ->orderBy('c_user_pegawai.id_user_pegawai', 'ASC');

        if ($id !== null) {
            return $builder->where('c_user_pegawai.' . $this->primaryKey, $id)->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }
}
