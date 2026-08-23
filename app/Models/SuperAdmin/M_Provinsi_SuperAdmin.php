<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Provinsi_SuperAdmin extends Model
{
    protected $table            = 'm_provinsi';
    protected $primaryKey       = 'id_provinsi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode_provinsi', 'nama_provinsi', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
