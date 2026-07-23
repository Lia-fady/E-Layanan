<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_FilePermohonan extends Model
{
    protected $table            = 'm_file_permohonan';
    protected $primaryKey       = 'id_file_permohonan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_file', 'id_jenis_permohonan', 'status_aktif'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
}

