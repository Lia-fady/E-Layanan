<?php

namespace App\Models\SuperAdmin;

use CodeIgniter\Model;

class M_JenisPermohonan_SuperAdmin extends Model
{
    protected $table            = 'm_jenis_permohonan';
    protected $primaryKey       = 'id_jenis_permohonan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['jenis_permohonan', 'deskripsi', 'durasi_minimal', 'maksimal_permohonan', 'maksimal_hari_pengajuan', 'durasi_permohonan', 'menggunakan_kuota', 'menggunakan_logbook', 'status'];
}
