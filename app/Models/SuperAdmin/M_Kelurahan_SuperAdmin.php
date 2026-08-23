<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Kelurahan_SuperAdmin extends Model
{
    protected $table            = 'm_kelurahan';
    protected $primaryKey       = 'id_kelurahan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kecamatan', 'nama_kelurahan', 'kode_pos', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
