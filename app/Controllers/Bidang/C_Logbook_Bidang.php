<?php
namespace App\Controllers\Bidang;

use App\Controllers\BaseController;
use App\Models\Bidang\M_Logbook_Bidang;

class C_Logbook_Bidang extends BaseController
{
    protected $logbookModel;

    public function __construct()
    {
        $this->logbookModel = new M_Logbook_Bidang();
    }

    public function index()
    {
        $id_bidang = session('id_bidang');
        
        $data = [
            'title'       => 'Logbook Mahasiswa',
            'active_menu' => 'logbook',
            'mahasiswa'   => $this->logbookModel->getActiveMahasiswa($id_bidang)
        ];

        return view('dashboard/bidang/v_logbook_mahasiswa', $data);
    }

    public function detail($id_penempatan)
    {
        $mahasiswaInfo = $this->logbookModel->getMahasiswaInfo($id_penempatan);
        
        if (!$mahasiswaInfo) {
            return redirect()->to(base_url('kabid/logbook'))->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $data = [
            'title'         => 'Detail Logbook Mahasiswa',
            'active_menu'   => 'logbook',
            'mahasiswa'     => $mahasiswaInfo,
            'logbooks'      => $this->logbookModel->getLogbooks($id_penempatan)
        ];

        return view('dashboard/bidang/v_logbook_detail_approval', $data);
    }

    public function approve()
    {
        $id_logbook = $this->request->getPost('id_logbook_magang');
        $id_penempatan = $this->request->getPost('id_penempatan_magang');

        $db = \Config\Database::connect();
        $userPegawai = $db->table('c_user_pegawai')->where('id_user_pegawai', session('id_user_pegawai'))->get()->getRow();
        
        $ttd = $userPegawai ? $userPegawai->file_tanda_tangan : null;

        $updateData = [
            'disetujui_oleh'    => session('id_user_pegawai'),
            'tgl_disetujui'     => date('Y-m-d H:i:s'),
            'file_tanda_tangan' => $ttd,
            'updated_by'        => session('id_user_pegawai')
        ];

        $this->logbookModel->update($id_logbook, $updateData);

        return redirect()->to(base_url('kabid/logbook/detail/' . $id_penempatan))->with('success', 'Logbook berhasil disetujui.');
    }

    public function bulkApprove()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');

        $db = \Config\Database::connect();
        $userPegawai = $db->table('c_user_pegawai')->where('id_user_pegawai', session('id_user_pegawai'))->get()->getRow();
        
        $ttd = $userPegawai ? $userPegawai->file_tanda_tangan : null;

        $updateData = [
            'disetujui_oleh'    => session('id_user_pegawai'),
            'tgl_disetujui'     => date('Y-m-d H:i:s'),
            'file_tanda_tangan' => $ttd,
            'updated_by'        => session('id_user_pegawai')
        ];

        $affectedRows = $this->logbookModel->bulkApprovePending($id_penempatan, $updateData);

        if ($affectedRows > 0) {
            return redirect()->to(base_url('kabid/logbook/detail/' . $id_penempatan))->with('success', $affectedRows . ' catatan logbook berhasil disetujui sekaligus.');
        } else {
            return redirect()->to(base_url('kabid/logbook/detail/' . $id_penempatan))->with('error', 'Tidak ada logbook pending yang bisa disetujui.');
        }
    }
}
