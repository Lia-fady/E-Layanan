<?php
namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\KuotaBidangModel;

class C_KuotaBidang extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $list_bidang = $db->table('m_bidang')->get()->getResultArray();

        $data = [
            'title'            => 'Kuota Bidang',
            'active_menu'      => 'kuota',
            'list_bidang'      => $list_bidang
        ];

        return view('dashboard/sekretariat/v_kuota_bidang', $data);
    }

    public function detail($id_bidang)
    {
        // Tahun di-set ke 2026 sesuai permintaan (atau bisa diambil dari parameter GET jika diperlukan)
        $tahun = $this->request->getGet('tahun') ?? 2026;

        $db = \Config\Database::connect();
        $bidang = $db->table('m_bidang')->where('id_bidang', $id_bidang)->get()->getRowArray();
        
        if (!$bidang) {
            return redirect()->to(base_url('sekretariat/kuota'))->with('error', 'Bidang tidak ditemukan');
        }

        $kuotaModel = new KuotaBidangModel();
        $kuota_bulan = $kuotaModel->getKuotaPerBulan($id_bidang, $tahun);

        $data = [
            'title'            => 'Detail Kuota Bidang',
            'active_menu'      => 'kuota',
            'tahun'            => $tahun,
            'bidang'           => $bidang,
            'kuota_bulan'      => $kuota_bulan
        ];

        return view('dashboard/sekretariat/v_kuota_detail', $data);
    }
}
