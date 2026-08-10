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
        
        // Dapatkan data kuota 12 bulan (sudah mencakup perhitungan terpakai dan sisa)
        $list_kuota = $kuotaModel->getKuotaPerBulan($id_bidang, $tahun);

        $data = [
            'title'       => 'Kuota Magang Bidang',
            'active_menu' => 'kuota',
            'list_kuota'  => $list_kuota,
            'tahun'       => $tahun
        ];

        return view('dashboard/kabid/v_kuota_bidang', $data);
    }

    public function update()
    {
        $id_kuota = $this->request->getPost('id_kuota');
        $jumlah = $this->request->getPost('kuota');

        if (!$id_kuota || $jumlah < 0) {
            return redirect()->back()->with('error', 'Data tidak valid.');
        }

        $db = \Config\Database::connect();
        $db->table('m_kuota')->where('id_kuota', $id_kuota)->update([
            'kuota' => $jumlah
        ]);

        return redirect()->to(base_url('kabid/kuota'))->with('success', 'Kuota berhasil diperbarui.');
    }
}
