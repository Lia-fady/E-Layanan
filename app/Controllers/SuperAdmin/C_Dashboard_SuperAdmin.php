<?php

namespace App\Controllers\SuperAdmin;

use App\Controllers\BaseController;

class C_Dashboard_SuperAdmin extends BaseController
{
    public function index()
    {
        $mDashboard = new \App\Models\SuperAdmin\M_DashboardSuperAdmin();
        $stats = $mDashboard->getSuperAdminStats();
        
        $totalPengguna = $stats['totalPengguna'];
        $menuAktif = $stats['menuAktif'];
        $totalPermohonan = $stats['totalPermohonan'];

        $distribusiPeran = $stats['distribusiPeran'];
        $aktivitasTerbaru = $stats['aktivitasTerbaru'];

        // Menyiapkan data untuk dikirim ke view
        $data = [
            'title'            => 'Dashboard',
            'active_menu'      => 'dashboard',
            'totalPengguna'    => $totalPengguna,
            'menuAktif'        => $menuAktif,
            'totalPermohonan'  => $totalPermohonan,
            'distribusiPeran'  => $distribusiPeran,
            'aktivitasTerbaru' => $aktivitasTerbaru,
        ];

        return view('dashboard/superadmin/v_dashboard', $data);
    }
}


