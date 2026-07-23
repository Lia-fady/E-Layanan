<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class LogbookMagangModel extends Model
{
    protected $table            = 't_logbook_magang';
    protected $primaryKey       = 'id_logbook_magang'; // sesuaikan dengan ERD-mu
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'id_penempatan_magang', 'tgl_logbook', 'logbook_magang', 
        'disetujui_oleh', 'file_tanda_tangan', 'tgl_disetujui', 
        'updated_by', 'created_at'
    ];

    /**
     * Mengambil penempatan kerja mahasiswa yang berstatus DISETUJUI
     */
    public function cekPenempatanAktif($id_mahasiswa)
    {
        return $this->db->table('t_penempatan_magang')
            ->select('t_penempatan_magang.*')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_persetujuan_magang = t_penempatan_magang.id_persetujuan_magang')
            ->join('t_permohonan_magang', 't_permohonan_magang.id_permohonan_magang = t_persetujuan_magang.id_permohonan_magang')
            ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
            ->where('t_persetujuan_magang.status_persetujuan', 'DISETUJUI')
            ->whereIn('t_penempatan_magang.status_penempatan', ['BERJALAN', 'SELESAI'])
            ->get()->getRowArray();
    }
}
