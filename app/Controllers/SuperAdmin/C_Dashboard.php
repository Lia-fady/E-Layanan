<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Dashboard extends BaseController
{
    public function index()
    {
        $mDashboard = new \App\Models\M_Dashboard();
        $stats = $mDashboard->getSuperAdminStats();
        
        $totalPengguna = $stats['totalPengguna'];
        $menuAktif = $stats['menuAktif'];
        $totalPermohonan = $stats['totalPermohonan'];

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'title'           => 'Dashboard',
            'active_menu'     => 'dashboard',
            'totalPengguna'   => $totalPengguna,
            'menuAktif'       => $menuAktif,
            'totalPermohonan' => $totalPermohonan,
        ];

        return view('dashboard/superadmin/v_dashboard', $data);
    }
}
