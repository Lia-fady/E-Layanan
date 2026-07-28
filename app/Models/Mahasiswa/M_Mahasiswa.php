<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_Mahasiswa extends Model
{
    protected $table            = 'm_mahasiswa';
    protected $primaryKey       = 'id_mahasiswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Fitur otomatis untuk mencatat created_at dan updated_at
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Kolom-kolom yang wajib didaftarkan agar bisa diisi lewat kodingan
    protected $allowedFields    = [
        'nik',
        'nim', 
        'nama_mahasiswa', 
        'jenis_kelamin', 
        'tgl_lahir', 
        'alamat', 
        'rt', 
        'rw', 
        'kelurahan', 
        'kecamatan', 
        'provinsi', 
        'no_telp', 
        'id_instansi_mahasiswa', 
        'email'
    ];
}
