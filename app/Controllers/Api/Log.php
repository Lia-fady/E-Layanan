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

        $bulanIndo = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];

        // Format tanggal agar lebih manusiawi
        foreach ($logs as &$log) {
            $t = strtotime($log['created_at']);
            $m = (int)date('n', $t);
            $log['tanggal_format'] = date('d', $t) . ' ' . $bulanIndo[$m] . ' ' . date('Y, H:i', $t);
            
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
