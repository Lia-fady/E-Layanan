<?php
namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_File;
use App\Models\Sekretariat\M_FileProsesMagang;

class C_UploadSuratPenerimaan extends BaseController
{
    protected $fileModel;
    protected $fileProsesModel;

    public function __construct()
    {
        $this->fileModel = new M_File();
        $this->fileProsesModel = new M_FileProsesMagang();
    }

    public function index()
    {
        return redirect()->to(base_url('sekretariat/riwayat'));
    }

    private function getPersetujuanDetail($id_persetujuan)
    {
        $db = \Config\Database::connect();
        return $db->table('t_persetujuan_magang ps')
            ->select('ps.*, pm.tgl_mulai, pm.tgl_selesai, mhs.nama_mahasiswa, mhs.nim, ip.instansi_pendidikan, pr.prodi')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left')
            ->join('m_mahasiswa mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi', 'left')
            ->where('ps.id_persetujuan_magang', $id_persetujuan)
            ->get()->getRow();
    }

    public function form($id_persetujuan)
    {
        $persetujuan = $this->getPersetujuanDetail($id_persetujuan);
        if (!$persetujuan) {
            return "Data persetujuan tidak ditemukan.";
        }

        $data = [
            'persetujuan' => $persetujuan,
            'jenis_file'  => $this->fileModel->getActiveFiles(),
            // Mengambil semua surat yang diupload (mendukung multiple files)
            'files'       => $this->fileProsesModel->where('id_persetujuan_magang', $id_persetujuan)->where('proses_magang', 'PERSETUJUAN_MAGANG')->findAll(),
        ];

        return view('dashboard/sekretariat/v_upload_surat_modal', $data);
    }

    public function store()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/riwayat'));
        }

        $validationRules = [
            'id_persetujuan_magang' => 'required',
            'id_file'               => 'required',
            'file_surat'            => [
                'rules'  => 'uploaded[file_surat]|max_size[file_surat,5120]|ext_in[file_surat,pdf,doc,docx]|mime_in[file_surat,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'errors' => [
                    'uploaded' => 'File surat harus diunggah.',
                    'max_size' => 'Ukuran file maksimal 5MB.',
                    'ext_in'   => 'Format file hanya diperbolehkan PDF, DOC, atau DOCX.',
                    'mime_in'  => 'Format file tidak valid.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Validasi gagal.', 'errors' => $this->validator->getErrors()]);
        }

        $id_persetujuan = $this->request->getPost('id_persetujuan_magang');
        
        $db = \Config\Database::connect();
        $cekPersetujuan = $db->table('t_persetujuan_magang')
                             ->where('id_persetujuan_magang', $id_persetujuan)
                             ->get()->getRow();
                             
        if (!$cekPersetujuan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data persetujuan magang tidak valid atau tidak ditemukan.']);
        }

        $file = $this->request->getFile('file_surat');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->store('surat_penerimaan_magang/', $newName);
            
            $path_file = 'uploads/surat_penerimaan_magang/' . $newName;

            $this->fileProsesModel->insert([
                'id_persetujuan_magang' => $id_persetujuan,
                'id_file'               => $this->request->getPost('id_file'),
                'nama_file'             => $file->getClientName(),
                'path_file'             => $path_file,
                'proses_magang'         => 'PERSETUJUAN_MAGANG', // Sesuai enum
                'created_by'            => session('id_user_pegawai')
            ]);

            return $this->response->setJSON(['success' => true, 'message' => 'Surat penerimaan berhasil diunggah.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengunggah file.']);
    }

    public function delete($id_file_selesai)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/riwayat'));
        }

        $existing = $this->fileProsesModel->find($id_file_selesai);
        if (!$existing) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak ditemukan.']);
        }

        $oldFilePath = WRITEPATH . $existing['path_file'];
        if (file_exists($oldFilePath) && is_file($oldFilePath)) {
            unlink($oldFilePath);
        }

        $this->fileProsesModel->delete($id_file_selesai);

        return $this->response->setJSON(['success' => true, 'message' => 'Surat penerimaan berhasil dihapus.']);
    }

    public function download($id_file_selesai)
    {
        $fileData = $this->fileProsesModel->find($id_file_selesai);
        if (!$fileData) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = WRITEPATH . $fileData['path_file'];
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File fisik tidak ditemukan di server.');
        }

        return $this->response->download($filePath, null)->setFileName($fileData['nama_file']);
    }
}
