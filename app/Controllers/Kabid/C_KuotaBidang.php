<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;

class C_KuotaBidang extends BaseController
{
    public function index()
    {
        $id_bidang = session('id_bidang');
        $tahun = $this->request->getGet('tahun') ?? date('Y');

        $kuotaModel = new \App\Models\KuotaBidangModel();
        
        $db = \Config\Database::connect();
        $bidang_row = $db->table('m_bidang')->where('id_bidang', $id_bidang)->get()->getRowArray();
        $nama_bidang = $bidang_row ? $bidang_row['bidang'] : 'Bidang Anda';
        
        // Dapatkan data kuota 12 bulan (sudah mencakup perhitungan terpakai dan sisa)
        $list_kuota = $kuotaModel->getKuotaPerBulan($id_bidang, $tahun);

        $data = [
            'title'       => 'Kuota Magang Bidang',
            'active_menu' => 'kuota',
            'list_kuota'  => $list_kuota,
            'tahun'       => $tahun,
            'nama_bidang' => $nama_bidang
        ];

        return view('dashboard/kabid/v_kuota_bidang', $data);
    }

    public function update()
    {
        $id_kuota = $this->request->getPost('id_kuota');
        $jumlah = (int)$this->request->getPost('kuota');

        if (!$id_kuota || $jumlah < 0) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak valid.']);
            }
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        $db = \Config\Database::connect();
        $kuota_row = $db->table('m_kuota')->where('id_kuota', $id_kuota)->get()->getRowArray();
        
        if (!$kuota_row) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data kuota tidak ditemukan.']);
            }
            return redirect()->back()->with('error', 'Data kuota tidak ditemukan.');
        }

        $kuotaModel = new \App\Models\KuotaBidangModel();
        $list_kuota = $kuotaModel->getKuotaPerBulan($kuota_row['id_bidang'], $kuota_row['tahun']);
        
        $terpakai = 0;
        foreach ($list_kuota as $k) {
            if ($k['id_kuota'] == $id_kuota) {
                $terpakai = $k['terpakai'];
                break;
            }
        }

        if ($jumlah < $terpakai) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Kuota tidak boleh lebih kecil dari jumlah mahasiswa yang sudah terpakai ('.$terpakai.').']);
            }
            return redirect()->back()->with('error', 'Kuota tidak boleh lebih kecil dari jumlah terpakai.');
        }

        $db->table('m_kuota')->where('id_kuota', $id_kuota)->update([
            'kuota' => $jumlah
        ]);

        $sisa = max(0, $jumlah - $terpakai);
        $status = $sisa > 0 ? 'Tersedia' : 'Penuh';

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Kuota berhasil diperbarui.',
                'data' => [
                    'kuota' => $jumlah,
                    'sisa' => $sisa,
                    'status_text' => $status
                ]
            ]);
        }

        return redirect()->to(base_url('kabid/kuota'))->with('success', 'Kuota berhasil diperbarui.');
    }
}
