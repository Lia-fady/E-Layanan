<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Helpers\LogbookTimeHelper;
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
        if ($this->request->isAJAX() && $this->request->getPost('action') === 'get_detail') {
            $id_penempatan = $this->request->getPost('id');
            $mahasiswaInfo = $this->logbookModel->getMahasiswaInfo($id_penempatan);
            
            if (!$mahasiswaInfo) {
                return "Data mahasiswa tidak ditemukan.";
            }

            $data = [
                'mahasiswa' => $mahasiswaInfo,
                'logbooks'  => $this->logbookModel->getLogbooks($id_penempatan)
            ];

            return view('dashboard/kabid/v_logbook_detail_approval', $data);
        }

        $id_bidang = session('id_bidang');
        $db = \Config\Database::connect();
        
        $data = [
            'title'       => 'Logbook Mahasiswa',
            'active_menu' => 'logbook',
            'mahasiswa'   => $this->logbookModel->getActiveMahasiswa($id_bidang, null, null, null),
            'list_jenis'  => $db->table('m_jenis_permohonan')->get()->getResultArray()
        ];

        return view('dashboard/kabid/v_logbook_mahasiswa', $data);
    }

    public function riwayatSelesai()
    {
        if ($this->request->isAJAX() && $this->request->getGet('action') === 'detail' && $this->request->getGet('id')) {
            $id_penempatan = $this->request->getGet('id');
            $detail = $this->logbookModel->getDetailPenempatan($id_penempatan);

            if (!$detail) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data mahasiswa tidak ditemukan.']);
            }

            $db = \Config\Database::connect();
            $originalFiles = $db->table('t_file_permohonan_magang f')
                ->select('f.nama_file, f.path_file, mp.id_file')
                ->join('m_file_permohonan mp', 'mp.id_file_permohonan = f.id_file_permohonan', 'left')
                ->where('f.id_permohonan_magang', $detail->id_permohonan_magang)
                ->get()
                ->getResult();

            $finalFiles = $db->table('t_file_proses_magang f')
                ->select('f.id_file_selesai_magang, f.nama_file, f.path_file, mf.nama_file as nama_file_master')
                ->join('m_file mf', 'mf.id_file = f.id_file', 'left')
                ->where('f.id_persetujuan_magang', $detail->id_persetujuan_magang)
                ->get()
                ->getResult();

            $cvFile = null;
            $ktmFile = null;
            foreach ($originalFiles as $file) {
                if (in_array($file->id_file, [3, 4, 7]) && $cvFile === null) {
                    $cvFile = $file;
                }
                if ($file->id_file == 11 && $ktmFile === null) {
                    $ktmFile = $file;
                }
            }

            $suratSelesaiFile = null;
            foreach ($finalFiles as $file) {
                if ($file->nama_file_master && stripos($file->nama_file_master, 'selesai') !== false) {
                    $suratSelesaiFile = $file;
                    break;
                }
            }
            if (!$suratSelesaiFile && !empty($finalFiles)) {
                $suratSelesaiFile = $finalFiles[0];
            }

            return $this->response->setJSON([
                'status' => 'success',
                'data'   => [
                    // DATA PENDIDIKAN
                    'instansi_pendidikan' => $detail->instansi_pendidikan ?? '-',
                    'fakultas'            => $detail->fakultas ?? '-',
                    'prodi'               => $detail->prodi ?? '-',
                    'semester'            => $detail->semester ?? '-',
                    'angkatan_tahun'      => $detail->angkatan_tahun ?? '-',
                    'tahun_akademik'      => $detail->tahun_akademik ?? '-',
                    'jenjang_pendidikan'  => $detail->jenjang_pendidikan ?? '-',
                    // DATA PRIBADI
                    'nik'                 => $detail->nik ?? '-',
                    'nim'                 => $detail->nim ?? '-',
                    'nama_mahasiswa'      => $detail->nama_mahasiswa ?? '-',
                    'email'               => $detail->email ?? '-',
                    'no_telp'             => $detail->no_telp ?? '-',
                    'jenis_kelamin'       => $detail->jenis_kelamin === 'L' ? 'Laki-laki' : ($detail->jenis_kelamin === 'P' ? 'Perempuan' : ($detail->jenis_kelamin ?? '-')),
                    'tgl_lahir'           => $detail->tgl_lahir ? date('d F Y', strtotime($detail->tgl_lahir)) : '-',
                    'alamat'              => $detail->alamat ?? '-',
                    'rt'                  => $detail->rt ?? '-',
                    'rw'                  => $detail->rw ?? '-',
                    'kelurahan'           => $detail->kelurahan ?? '-',
                    'kecamatan'           => $detail->kecamatan ?? '-',
                    'provinsi'            => $detail->provinsi ?? '-',
                    // DETAIL MAGANG
                    'jenis_permohonan'    => $detail->jenis_permohonan ?? '-',
                    'tgl_mulai'           => $detail->tgl_mulai,
                    'tgl_selesai'         => $detail->tgl_selesai,
                    'status_akhir'        => $detail->status_penempatan,
                    // FILE DOKUMEN
                    'surat_selesai'       => $suratSelesaiFile ? [
                        'label'     => $suratSelesaiFile->nama_file_master ?? 'Surat Keterangan Selesai Magang',
                        'nama_file' => $suratSelesaiFile->nama_file,
                        'url'       => base_url('kabid/upload-dokumen/download/' . $suratSelesaiFile->id_file_selesai_magang)
                    ] : null,
                    'cv' => $cvFile ? [
                        'label'     => 'Curriculum Vitae (CV)',
                        'nama_file' => $cvFile->nama_file,
                        'url'       => base_url($cvFile->path_file)
                    ] : null,
                    'ktm' => $ktmFile ? [
                        'label'     => 'Kartu Tanda Mahasiswa (KTM)',
                        'nama_file' => $ktmFile->nama_file,
                        'url'       => base_url($ktmFile->path_file)
                    ] : null,
                ]
            ]);
        }

        $id_bidang = session('id_bidang');
        $db = \Config\Database::connect();

        $data = [
            'title'       => 'Riwayat Disposisi Magang',
            'active_menu' => 'riwayat_selesai',
            'mahasiswa'   => $this->logbookModel->getActiveMahasiswa($id_bidang, null, null, 'SELESAI'),
            'list_jenis'  => $db->table('m_jenis_permohonan')->get()->getResultArray()
        ];

        return view('dashboard/kabid/v_riwayat_selesai', $data);
    }

    public function approve()
    {
        $id_logbook = $this->request->getPost('id_logbook_magang');
        $id_penempatan = $this->request->getPost('id_penempatan_magang');

        $db = \Config\Database::connect();
        $userPegawai = $db->table('c_user_pegawai')->where('id_user_pegawai', session('id_user_pegawai'))->get()->getRow();
        
        $ttd = $userPegawai ? $userPegawai->file_tanda_tangan : null;
        $timestamp = LogbookTimeHelper::getServerNow('Y-m-d H:i:s');

        $updateData = [
            'status_logbook'    => 'disetujui',
            'disetujui_oleh'    => session('id_user_pegawai'),
            'tgl_disetujui'     => $timestamp,
            'file_tanda_tangan' => $ttd,
            'updated_by'        => session('id_user_pegawai')
        ];

        $this->logbookModel->update($id_logbook, $updateData);

        return $this->response->setJSON(['success' => true, 'message' => 'Logbook berhasil disetujui.']);
    }

    public function bulkApprove()
    {
        $id_penempatan = $this->request->getPost('id_penempatan_magang');
        $selectedIds = $this->request->getPost('selected_ids');

        if (empty($selectedIds) || !is_array($selectedIds)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Pilih minimal satu aktivitas untuk disetujui.']);
        }

        $db = \Config\Database::connect();
        $userPegawai = $db->table('c_user_pegawai')->where('id_user_pegawai', session('id_user_pegawai'))->get()->getRow();
        
        $ttd = $userPegawai ? $userPegawai->file_tanda_tangan : null;
        $timestamp = LogbookTimeHelper::getServerNow('Y-m-d H:i:s');

        $updateData = [
            'status_logbook'    => 'disetujui',
            'disetujui_oleh'    => session('id_user_pegawai'),
            'tgl_disetujui'     => $timestamp,
            'file_tanda_tangan' => $ttd,
            'updated_by'        => session('id_user_pegawai')
        ];

        $selectedIds = array_values(array_filter(array_map('intval', $selectedIds)));
        $affectedRows = $this->logbookModel->bulkApproveSelected($id_penempatan, $selectedIds, $updateData);

        if ($affectedRows > 0) {
            return $this->response->setJSON(['success' => true, 'message' => $affectedRows . ' catatan logbook berhasil disetujui sekaligus.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada logbook yang dapat disetujui dari pilihan Anda.']);
    }
}
