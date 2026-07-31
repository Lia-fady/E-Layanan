<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_JenisPermohonan extends Model
{
    protected $table            = 'm_jenis_permohonan';
    protected $primaryKey       = 'id_jenis_permohonan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_jenis_permohonan', 'jenis_permohonan', 'status'];
}
