<?php

namespace App\Models;

use CodeIgniter\Model;

class LogPermohonanModel extends Model
{
    protected $table            = 't_log_permohonan';
    protected $primaryKey       = 'id_log';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_permohonan_magang', 'aktor', 'aksi', 'catatan', 'created_at'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';

}
