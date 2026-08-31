<?php

namespace App\Models\Common;

use CodeIgniter\Model;

class PersetujuanMagangModel extends Model
{
    protected $table            = 't_persetujuan_magang';
    protected $primaryKey       = 'id_persetujuan_magang';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    
    // Mempertahankan fields asli kelompokmu sesuai ERD
    protected $allowedFields    = ['id_permohonan_magang', 'id_bidang', 'catatan', 'status_persetujuan', 'disposisi', 'tanggal_disposisi', 'tanggal_persetujuan', 'tgl_mulai_disetujui', 'tgl_selesai_disetujui', 'status_persetujuan_mahasiswa', 'created_at', 'created_by', 'updated_at', 'updated_by'];
    protected $useSoftDeletes   = false;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
 // Diisi manual di controller biar aman
}