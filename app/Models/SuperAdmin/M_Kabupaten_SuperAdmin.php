<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Kabupaten_SuperAdmin extends Model
{
    protected $table            = 'm_kabupaten';
    protected $primaryKey       = 'id_kabupaten';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_provinsi', 'nama_kabupaten', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
