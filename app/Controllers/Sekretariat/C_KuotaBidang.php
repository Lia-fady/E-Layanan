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
        // Redirect ke daftar jika diakses langsung (non-AJAX) untuk menjaga URL bersih di /sekretariat/kuota
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/kuota'));
        }

        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $db = \Config\Database::connect();
        $bidang = $db->table('m_bidang')->where('id_bidang', $id_bidang)->get()->getRowArray();
        
        if (!$bidang) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Bidang tidak ditemukan']);
        }

        $kuotaModel = new KuotaBidangModel();
        // Menggunakan method khusus sekretariat sesuai PRD (hanya status BERJALAN)
        $dataDetail = $kuotaModel->getKuotaDetailSekretariat($id_bidang, $tahun);

        // Daftar tahun yang tersedia untuk dropdown filter
        $available_years = $kuotaModel->getAvailableYears($id_bidang);

        return $this->response->setJSON([
            'status' => 'success',
            'bidang' => $bidang,
            'tahun'  => $tahun,
            'data'   => $dataDetail,
            'available_years' => $available_years
        ]);
    }
}
