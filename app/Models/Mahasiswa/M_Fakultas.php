<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_Fakultas extends Model
{
    protected $table            = 'm_fakultas';
    protected $primaryKey       = 'id_fakultas';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_instansi_pendidikan', 'fakultas', 'status', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}

