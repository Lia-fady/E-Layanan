<?php
namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\KuotaBidangModel;

class C_Kuota extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $tahun = date('Y');
        
        // Fetch all bidangs and their quota limit
        $bidangs = $db->table('m_bidang b')
            ->select('b.id_bidang, b.bidang, IFNULL(k.kuota, 0) as kuota_limit')
            ->join('m_kuota k', 'k.id_bidang = b.id_bidang', 'left')
            ->where('b.status_aktif', 1)
            ->get()->getResult();

        $kuotaModel = new KuotaBidangModel();
        
        foreach ($bidangs as $b) {
            $b->rekap_bulanan = $kuotaModel->getRekapKuotaBulanan($b->id_bidang, $tahun);
        }

        $data = [
            'title'       => 'Pemantauan Kuota Bidang',
            'active_menu' => 'kuota_bidang',
            'tahun'       => $tahun,
            'bidangs'     => $bidangs
        ];

        return view('dashboard/sekretariat/kuota/index', $data);
    }
}
