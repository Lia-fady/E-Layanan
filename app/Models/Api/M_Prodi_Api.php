<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class M_Prodi_Api extends Model
{
    protected $table            = 'm_prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_fakultas', 'prodi', 'status', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
