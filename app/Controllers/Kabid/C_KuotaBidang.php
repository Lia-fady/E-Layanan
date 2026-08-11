<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;

class C_KuotaBidang extends BaseController
{
    public function index()
    {
        $id_bidang = session('id_bidang');
        $db = \Config\Database::connect();

        $kuota = $db->table('m_kuota k')
            ->select('k.id_kuota, k.kuota, k.status as status_aktif, b.bidang')
            ->join('m_bidang b', 'b.id_bidang = k.id_bidang')
            ->where('k.id_bidang', $id_bidang)
            ->get()->getRow();

        // Auto-create initial kuota if not exists
        if (!$kuota && $id_bidang) {
            $db->table('m_kuota')->insert([
                'id_bidang' => $id_bidang,
                'kuota' => 0,
                'status' => 'AKTIF'
            ]);
            // Re-fetch after insert
            $kuota = $db->table('m_kuota k')
                ->select('k.id_kuota, k.kuota, k.status as status_aktif, b.bidang')
                ->join('m_bidang b', 'b.id_bidang = k.id_bidang')
                ->where('k.id_bidang', $id_bidang)
                ->get()->getRow();
        }

        $tahun = date('Y');
        $kuotaModel = new \App\Models\KuotaBidangModel();
        $rekap_bulanan = $kuotaModel->getRekapKuotaBulanan($id_bidang, $tahun);

        $data = [
            'title'         => 'Kuota Magang Bidang',
            'active_menu'   => 'kuota',
            'kuota'         => $kuota,
            'tahun'         => $tahun,
            'rekap_bulanan' => $rekap_bulanan
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
