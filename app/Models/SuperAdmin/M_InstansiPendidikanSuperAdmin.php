<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_InstansiPendidikanSuperAdmin extends Model
{
    protected $table            = 'm_instansi_pendidikan';
    protected $primaryKey       = 'id_instansi_pendidikan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_instansi_pendidikan', 'instansi_pendidikan', 'jenis_instansi', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
