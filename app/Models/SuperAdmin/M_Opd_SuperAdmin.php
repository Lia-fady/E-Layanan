<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_OpdSuperAdmin extends Model
{
    protected $table            = 'm_opd';
    protected $primaryKey       = 'id_opd';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_opd', 'opd', 'status_aktif'];
}
