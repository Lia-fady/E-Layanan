<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Kecamatan_SuperAdmin extends Model
{
    protected $table            = 'm_kecamatan';
    protected $primaryKey       = 'id_kecamatan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kabupaten', 'nama_kecamatan', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
