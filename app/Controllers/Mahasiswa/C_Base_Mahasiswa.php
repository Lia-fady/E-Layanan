<?php

namespace App\Controllers\Mahasiswa;

use App\Controllers\Shared\C_Base;
use App\Models\Shared\M_PermohonanMagang;
use App\Models\Shared\M_LogbookMagang;
use App\Models\Shared\M_PenempatanMagang;

class C_Base_Mahasiswa extends C_Base
{
    protected $permohonanModel;
    protected $logbookModel;
    protected $penempatanModel;

    public function __construct()
    {
        // Inisialisasi semua model secara rapi sesuai standar MVC
        $this->permohonanModel = new M_PermohonanMagang_Mahasiswa();
        $this->logbookModel    = new M_LogbookMagang_Mahasiswa();
        $this->penempatanModel = new M_Penempatan_BidangMagang_Mahasiswa();
    }

    /**
     * Helper method to determine the state of the mahasiswa
     */
    protected function _getMahasiswaState($id_mahasiswa)
    {
        $db = \Config\Database::connect();

        $permohonan = $db->table('t_permohonan_magang')
            ->select('t_permohonan_magang.*, t_persetujuan_magang.id_persetujuan_magang, t_persetujuan_magang.status_persetujuan, t_persetujuan_magang.disposisi, t_persetujuan_magang.catatan as catatan_persetujuan, t_penempatan_magang.status_penempatan, t_penempatan_magang.is_log_book, t_penempatan_magang.catatan as catatan_penempatan')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_permohonan_magang = t_permohonan_magang.id_permohonan_magang', 'left')
            ->join('t_penempatan_magang', 't_penempatan_magang.id_persetujuan_magang = t_persetujuan_magang.id_persetujuan_magang', 'left')
            ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
            ->orderBy('t_permohonan_magang.created_at', 'DESC')
            ->limit(1)
            ->get()->getRowArray();

        $state = 1; 
        $jenis_permohonan = null;
        $catatan = '';

        if ($permohonan) {
            $jenis_permohonan = $permohonan['id_jenis_permohonan'];
            if ($permohonan['posting_data'] == 'draft') {
                $state = 1;
            } else {
                if ($permohonan['status_persetujuan'] == 'DITOLAK') {
                    $state = 3; 
                    $catatan = $permohonan['catatan_persetujuan'];
                } elseif ($permohonan['status_persetujuan'] == 'PERBAIKAN_BERKAS') {
                    $state = 6; 
                    $catatan = $permohonan['catatan_persetujuan'];
                } else {
                    // Jika belum diplot (status_penempatan kosong) atau masih menunggu persetujuan bidang
                    if (empty($permohonan['status_penempatan']) || $permohonan['status_penempatan'] == 'MENUNGGU') {
                        $state = 2; // Menunggu Verifikasi/Penempatan
                    } else {
                        if ($permohonan['status_penempatan'] == 'SELESAI') {
                            $state = 5; 
                        } elseif ($permohonan['status_penempatan'] == 'DIBATALKAN') {
                            $state = 3; 
                            $catatan = !empty($permohonan['catatan_penempatan']) ? $permohonan['catatan_penempatan'] : 'Penempatan Dibatalkan/Ditolak oleh Kepala Bidang';
                        } else {
                            $state = 4; // BERJALAN
                        }
                    }
                }
            }
        }

        return [
            'state'            => $state,
            'jenis_permohonan' => $jenis_permohonan,
            'is_log_book'      => $permohonan['is_log_book'] ?? 'tidak',
            'catatan'          => $catatan,
            'permohonan_aktif' => $permohonan
        ];
    }
}
