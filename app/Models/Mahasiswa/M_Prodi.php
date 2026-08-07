<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_Prodi extends Model
{
    protected $table            = 'm_prodi';
    protected $primaryKey       = 'id_prodi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_fakultas', 'nama_prodi', 'jenjang', 'status', 'created_at', 'updated_at', 'deleted_at'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $dateFormat    = 'datetime';
    
    
}

