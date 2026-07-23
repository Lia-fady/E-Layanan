<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_UserMahasiswa extends Model
{
    protected $table            = 'm_user_mahasiswa';
    protected $primaryKey       = 'id_user_mahasiswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Mengaktifkan fitur pencatatan waktu otomatis
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Kolom yang diizinkan untuk dimanipulasi (Insert / Update)
    protected $allowedFields    = [
        'id_mahasiswa', 
        'username', 
        'password', 
        'status'
    ];
}
