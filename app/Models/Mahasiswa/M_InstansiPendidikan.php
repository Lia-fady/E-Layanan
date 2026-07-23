<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_InstansiPendidikan extends Model
{
    protected $table            = 'm_instansi_pendidikan';
    protected $primaryKey       = 'id_instansi_pendidikan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Kolom yang diizinkan untuk dimanipulasi sesuai ERD
    protected $allowedFields    = [
        'instansi_pendidikan', 
        'jenis_instansi', 
        'status', 
        'created_at', 
        'updated_at'
    ];

    // Aktifkan pencatatan waktu otomatis bawaan CI4
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
