<?php

namespace App\Models\Shared;

use CodeIgniter\Model;

class M_PersetujuanMagang extends Model
{
    protected $table            = 't_persetujuan_magang';
    protected $primaryKey       = 'id_persetujuan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Mempertahankan fields asli kelompokmu sesuai ERD
    protected $allowedFields    = [
        'id_permohonan_magang',
        'catatan',
        'status_persetujuan', // MENUNGGU, DISETUJUI, DITOLAK
        'created_by',
        'updated_by',
        'disposisi',          // enum(0,1,2)
        'id_bidang',
        'tgl_persetujuan'
    ];

    protected $useTimestamps = false; // Diisi manual di controller biar aman
}