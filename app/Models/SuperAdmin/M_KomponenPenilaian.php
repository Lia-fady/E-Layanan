<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_KomponenPenilaian extends Model
{
    protected $table            = 'm_komponen_penilaian';
    protected $primaryKey       = 'id_komponen_penilaian';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_komponen_penilaian', 'komponen_penilaian', 'status_aktif'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
