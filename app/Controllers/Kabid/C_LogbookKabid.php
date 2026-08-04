<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Models\Kabid\M_LogbookKabid;

class C_LogbookKabid extends BaseController
{
    protected $logbookModel;

    public function __construct()
    {
        $this->logbookModel = new M_LogbookKabid();
    }

    public function index()
    {
        $id_bidang = session('id_bidang');
        $db = \Config\Database::connect();

        $data = [
            'title'            => 'Logbook Mahasiswa',
            'active_menu'      => 'logbook',
            'mahasiswa'        => $this->logbookModel->getActiveMahasiswa($id_bidang),
            'jenis_permohonan' => $db->table('m_jenis_permohonan')->get()->getResult(),
        ];

        return view('dashboard/kabid/v_logbook_mahasiswa', $data);
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

        return view('dashboard/kabid/v_logbook_detail_approval', $data);
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
