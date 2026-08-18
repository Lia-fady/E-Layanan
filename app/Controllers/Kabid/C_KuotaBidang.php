<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Models\KuotaBidangModel;

class C_KuotaBidang extends BaseController
{
    public function index()
    {
        $id_bidang = session('id_bidang');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $kuotaModel = new KuotaBidangModel();
        
        $db = \Config\Database::connect();
        $bidang_row = $db->table('m_bidang')->where('id_bidang', $id_bidang)->get()->getRowArray();
        $nama_bidang = $bidang_row ? $bidang_row['bidang'] : 'Bidang Anda';
        
        // Dapatkan data kuota 12 bulan (tanpa auto-insert)
        $list_kuota = $kuotaModel->getKuotaPerBulan($id_bidang, $tahun);

        // Hitung bulan terpakai untuk ditampilkan
        $bulanTerpakaiArr = [];
        foreach ($list_kuota as $k) {
            if ($k['terpakai'] > 0) {
                $bulanTerpakaiArr[] = '<div class="d-inline-flex align-items-center bg-white border rounded px-3 py-2 mr-2 mb-2 shadow-sm" style="border-color:#e2e8f0!important;"><span class="font-weight-bold text-dark mr-2" style="font-size:0.95rem;">' . $k['bulan_nama'] . '</span><span class="badge badge-primary px-2 py-1" style="font-size:0.85rem; background:#3b82f6;">' . $k['terpakai'] . '</span></div>';
            }
        }
        $bulan_terpakai = !empty($bulanTerpakaiArr) ? '<div class="d-flex flex-wrap mt-2">' . implode('', $bulanTerpakaiArr) . '</div>' : '<span class="text-muted mt-2 d-block"><i class="fas fa-info-circle mr-1"></i> Belum ada kuota yang terpakai</span>';

        // Dapatkan daftar tahun yang tersedia
        $available_years = $kuotaModel->getAvailableYears($id_bidang, $tahun);

        $data = [
            'title'           => 'Kuota Magang Bidang',
            'active_menu'     => 'kuota',
            'list_kuota'      => $list_kuota,
            'tahun'           => $tahun,
            'nama_bidang'     => $nama_bidang,
            'bulan_terpakai'  => $bulan_terpakai,
            'available_years' => $available_years
        ];

        return view('dashboard/kabid/v_kuota_bidang', $data);
    }

    /**
     * Halaman detail kuota per bulan.
     * URL: /kabid/kuota/{tahun}/{bulan}
     */
    public function detail($tahun, $bulan)
    {
        $id_bidang = session('id_bidang');
        $tahun = (int)$tahun;
        $bulan = (int)$bulan;

        if ($bulan < 1 || $bulan > 12) {
            return redirect()->to(base_url('kabid/kuota'))->with('error', 'Bulan tidak valid.');
        }

        $kuotaModel = new KuotaBidangModel();
        
        $db = \Config\Database::connect();
        $bidang_row = $db->table('m_bidang')->where('id_bidang', $id_bidang)->get()->getRowArray();
        $nama_bidang = $bidang_row ? $bidang_row['bidang'] : 'Bidang Anda';

        // Ambil data kuota single bulan
        $kuota_detail = $kuotaModel->getKuotaSingleBulan($id_bidang, $tahun, $bulan);

        if (!$kuota_detail) {
            return redirect()->to(base_url('kabid/kuota'))->with('error', 'Data kuota tidak ditemukan.');
        }

        $data = [
            'title'        => 'Detail Kuota ' . $kuota_detail['bulan_nama'] . ' ' . $tahun,
            'active_menu'  => 'kuota',
            'tahun'        => $tahun,
            'bulan'        => $bulan,
            'nama_bidang'  => $nama_bidang,
            'kuota_detail' => $kuota_detail
        ];

        return view('dashboard/kabid/v_kuota_detail_bidang', $data);
    }

    /**
     * Simpan/Update kuota berdasarkan id_bidang + tahun + bulan.
     */
    public function update()
    {
        $id_bidang = session('id_bidang');
        $tahun = (int)$this->request->getPost('tahun');
        $bulan = (int)$this->request->getPost('bulan');
        $jumlah = (int)$this->request->getPost('kuota');

        if (!$id_bidang || !$tahun || $bulan < 1 || $bulan > 12 || $jumlah < 0) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid.']);
            }
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        $kuotaModel = new KuotaBidangModel();

        // Hitung terpakai untuk validasi
        $kuota_data = $kuotaModel->getKuotaSingleBulan($id_bidang, $tahun, $bulan);
        $terpakai = $kuota_data ? $kuota_data['terpakai'] : 0;

        if ($jumlah < $terpakai) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Kuota tidak dapat lebih kecil dari jumlah yang sudah terpakai (' . $terpakai . ').'
                ]);
            }
            return redirect()->back()->with('error', 'Kuota tidak boleh lebih kecil dari jumlah terpakai.');
        }

        // Simpan (INSERT atau UPDATE)
        $kuotaModel->simpanKuota($id_bidang, $tahun, $bulan, $jumlah);

        $sisa = max(0, $jumlah - $terpakai);
        $status = $sisa > 0 ? 'Tersedia' : 'Penuh';

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Kuota berhasil disimpan.',
                'data' => [
                    'kuota' => $jumlah,
                    'sisa' => $sisa,
                    'status_text' => $status
                ]
            ]);
        }

        return redirect()->to(base_url('kabid/kuota/' . $tahun . '/' . $bulan))->with('success', 'Kuota berhasil disimpan.');
    }

    /**
     * Hapus semua data kuota untuk tahun tertentu.
     */
    public function deleteTahun()
    {
        $id_bidang = session('id_bidang');
        $tahun = (int)$this->request->getPost('tahun');

        if (!$id_bidang || !$tahun) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid.']);
        }

        $kuotaModel = new KuotaBidangModel();
        // Hapus semua data bulan untuk tahun tersebut
        $kuotaModel->where('id_bidang', $id_bidang)->where('tahun', $tahun)->delete();

        return $this->response->setJSON(['status' => 'success', 'message' => 'Tahun berhasil dihapus.']);
    }
}
