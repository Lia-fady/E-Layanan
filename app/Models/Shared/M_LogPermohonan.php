<?php

namespace App\Models\Shared;

use CodeIgniter\Model;

class M_LogPermohonan extends Model
{
    protected $table            = 't_log_permohonan';
    protected $primaryKey       = 'id_log';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_permohonan_magang',
        'aktor',
        'aksi',
        'catatan',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
}
