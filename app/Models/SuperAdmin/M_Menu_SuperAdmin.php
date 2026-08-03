<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_Menu_SuperAdmin extends Model
{
    protected $table            = 'c_menus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id', 'id_parent', 'name', 'url', 'position', 'icon', 'status', 'target_blank', 'created_by', 'updated_by'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
