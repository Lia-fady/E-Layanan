<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_File;
use App\Models\Sekretariat\M_FileProsesMagang;

class C_FileProsesMagangKabid extends BaseController
{
    protected $fileModel;
    protected $fileProsesModel;

    public function __construct()
    {
        $this->fileModel = new M_File();
        $this->fileProsesModel = new M_FileProsesMagang();
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

    public function create($id_persetujuan)
    {
        $persetujuan = $this->getPersetujuanDetail($id_persetujuan);
        if (!$persetujuan) {
            return redirect()->to(base_url('kabid/penempatan'))->with('error', 'Data persetujuan tidak ditemukan.');
        }

        $data = [
            'title'       => 'Upload Surat Penerimaan Magang',
            'active_menu' => 'penempatan',
            'persetujuan' => $persetujuan,
            'jenis_file'  => $this->fileModel->getActiveFiles(),
            'files'       => $this->fileProsesModel->getSuratByPersetujuan($id_persetujuan),
        ];

        return view('dashboard/kabid/v_file_proses_magang_kabid', $data);
    }

    public function store()
    {
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_persetujuan = $this->request->getPost('id_persetujuan_magang');
        
        $existing = $this->fileProsesModel->getExistingSurat($id_persetujuan);
        if ($existing) {
            return redirect()->back()->with('error', 'Surat penerimaan sudah ada. Gunakan tombol Ganti File jika ingin mengubahnya.');
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
                'proses_magang'         => 'SURAT_PENERIMAAN_MAGANG',
                'created_by'            => session('id_user_pegawai')
            ]);

            return redirect()->back()->with('success', 'Surat penerimaan berhasil diunggah.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    public function update($id_file_selesai)
    {
        $validationRules = [
            'id_file'    => 'required',
            'file_surat' => [
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
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $existing = $this->fileProsesModel->find($id_file_selesai);
        if (!$existing) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $file = $this->request->getFile('file_surat');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->store('surat_penerimaan_magang/', $newName);
            $path_file = 'uploads/surat_penerimaan_magang/' . $newName;

            $oldFilePath = WRITEPATH . $existing->path_file;
            if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                unlink($oldFilePath);
            }

            $this->fileProsesModel->update($id_file_selesai, [
                'id_file'    => $this->request->getPost('id_file'),
                'nama_file'  => $file->getClientName(),
                'path_file'  => $path_file,
                'updated_by' => session('id_user_pegawai')
            ]);

            return redirect()->back()->with('success', 'Surat penerimaan berhasil diganti.');
        }

        return redirect()->back()->with('error', 'Gagal mengunggah file.');
    }

    public function download($id_file_selesai)
    {
        $fileData = $this->fileProsesModel->find($id_file_selesai);
        if (!$fileData) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = WRITEPATH . $fileData->path_file;
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File fisik tidak ditemukan di server.');
        }

        return $this->response->download($filePath, null)->setFileName($fileData->nama_file);
    }
}
