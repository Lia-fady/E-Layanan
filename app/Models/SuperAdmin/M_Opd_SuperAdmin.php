<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Opd_SuperAdmin extends Model
{
    protected $table            = 'm_opd';
    protected $primaryKey       = 'id_opd';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['opd', 'singkatan', 'alamat', 'no_telepon', 'email', 'website', 'status_aktif'];
}
