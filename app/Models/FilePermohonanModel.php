<?php

namespace App\Models;

use CodeIgniter\Model;

class FilePermohonanModel extends Model
{
    protected $table            = 'm_file_permohonan';
    protected $primaryKey       = 'id_file_permohonan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = ['id_jenis_permohonan', 'id_file', 'urutan', 'wajib', 'created_at', 'updated_at'];
    protected $useSoftDeletes   = false;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;
}
