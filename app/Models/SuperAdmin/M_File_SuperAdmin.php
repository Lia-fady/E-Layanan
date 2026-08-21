<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_File_SuperAdmin extends Model
{
    protected $table            = 'm_file';
    protected $primaryKey       = 'id_file';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_file', 'kode_file', 'ekstensi', 'ukuran_maksimal', 'wajib_upload', 'status'];
}
