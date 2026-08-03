<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_InstansiMahasiswa extends Model
{
    protected $table            = 't_instansi_mahasiswa';
    protected $primaryKey       = 'id_instansi_mahasiswa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Kolom yang wajib diisi untuk jembatan data akademik sesuai ERD
    protected $allowedFields    = [
        'id_mahasiswa', 
        'id_instansi_pendidikan', 
        'id_fakultas',
        'id_prodi', 
        'jenjang_pendidikan', 
        'angkatan_tahun', 
        'semester', 
        'tahun_akademik', 
        'created_by', 
        'updated_at'
    ];

    // Menggunakan timestamps campuran sesuai kolom ERD kamu
    protected $useTimestamps = false; 
}
