<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Log extends BaseController
{
    public function get_riwayat($id_permohonan)
    {
        // Pastikan pengguna sudah login
        if (!session()->get('id_mahasiswa') && !session()->get('id_user_pegawai')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Unauthorized']);
        }

        $logModel = new \App\Models\LogPermohonanModel();
        
        $logs = $logModel->where('id_permohonan_magang', $id_permohonan)
                         ->orderBy('created_at', 'ASC') // Urutkan dari yang terlama ke terbaru
                         ->findAll();

        if (empty($logs)) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => []
            ]);
        }

        // Format tanggal agar lebih manusiawi
        foreach ($logs as &$log) {
            $date = date_create($log['created_at']);
            $log['tanggal_format'] = date_format($date, 'd M Y, H:i');
            
            // Tentukan warna ikon berdasarkan aksi
            $aksi = strtolower($log['aksi']);
            if (strpos($aksi, 'ditolak') !== false || strpos($aksi, 'dibatalkan') !== false) {
                $log['color_class'] = 'danger';
                $log['icon'] = 'bi-x-circle-fill';
            } elseif (strpos($aksi, 'disetujui') !== false || strpos($aksi, 'selesai') !== false || strpos($aksi, 'valid') !== false) {
                $log['color_class'] = 'success';
                $log['icon'] = 'bi-check-circle-fill';
            } elseif (strpos($aksi, 'draft') !== false) {
                $log['color_class'] = 'secondary';
                $log['icon'] = 'bi-file-earmark-fill';
            } else {
                $log['color_class'] = 'primary';
                $log['icon'] = 'bi-info-circle-fill';
            }
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $logs
        ]);
    }
}
