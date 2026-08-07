<?php

namespace App\Models\Mahasiswa;

use CodeIgniter\Model;

class M_LogbookMagang extends Model
{
    protected $table            = 't_logbook_magang';
    protected $primaryKey       = 'id_logbook_magang'; // sesuaikan dengan ERD-mu
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_penempatan_magang', 'logbook_magang', 'bukti_kegiatan', 'tgl_logbook', 'jam_logbook', 'status_logbook', 'catatan_revisi', 'disetujui_oleh', 'file_tanda_tangan', 'tgl_disetujui', 'created_at', 'updated_at', 'deleted_at'];
    protected $useSoftDeletes   = true;
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


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
