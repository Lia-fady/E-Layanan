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
        $db = \Config\Database::connect();
        $persetujuan = $db->table('t_persetujuan_magang ps')
            ->select('ps.*, pm.tgl_mulai, pm.tgl_selesai, mhs.nama_mahasiswa, mhs.nim, ip.instansi_pendidikan, pr.prodi')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left')
            ->join('m_mahasiswa mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi', 'left')
            ->where('ps.status_persetujuan', 'DISETUJUI')
            ->orderBy('ps.tgl_persetujuan', 'DESC')
            ->get()->getResult();

        $data = [
            'title'       => 'Daftar Surat Penerimaan Magang',
            'active_menu' => 'upload_surat_penerimaan',
            'persetujuan' => $persetujuan,
        ];

        return view('dashboard/sekretariat/v_upload_surat_penerimaan_index', $data);
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
            // Mengambil semua surat yang diupload menggunakan query model lengkap
            'files'       => $this->fileProsesModel->getSuratByPersetujuan($id_persetujuan),
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
                // Not strictly validating the array as a single uploaded file via CI rules since it's multiple.
                // We will validate each file manually below or through multiple rule.
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

        $files = $this->request->getFileMultiple('file_surat');
        if (empty($files)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Tidak ada file yang diunggah.']);
        }

        $prosesMagang = $this->request->getPost('proses_magang') ?? 'persetujuan';

        $berhasil = 0;
        foreach ($files as $file) {
            if ($file->isValid() && !$file->hasMoved()) {
                // Manual validation for each file to ensure correct size and extension
                $ext = $file->getClientExtension();
                $size = $file->getSize(); // in bytes
                
                if (!in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
                    continue; // Skip invalid extensions
                }
                if ($size > 5120000) {
                    continue; // Skip file > 5MB
                }

                $newName = $file->getRandomName();
                $file->store('surat_penerimaan_magang/', $newName);
                
                $path_file = 'uploads/surat_penerimaan_magang/' . $newName;

                // Logic khusus untuk 'persetujuan' (hanya 1 file)
                if ($prosesMagang === 'persetujuan') {
                    $existing = $this->fileProsesModel
                                     ->where('id_persetujuan_magang', $id_persetujuan)
                                     ->where('proses_magang', 'persetujuan')
                                     ->first();

                    if ($existing) {
                        // Hapus file fisik lama
                        $oldPath = WRITEPATH . $existing->path_file;
                        if (file_exists($oldPath) && is_file($oldPath)) {
                            unlink($oldPath);
                        }

                        // UPDATE
                        $this->fileProsesModel->update($existing->id_file_selesai_magang, [
                            'id_file'               => $this->request->getPost('id_file'),
                            'nama_file'             => $file->getClientName(),
                            'path_file'             => $path_file,
                            'updated_by'            => session('id_user_pegawai')
                        ]);
                        $berhasil++;
                        break; // Keluar dari loop, pastikan hanya 1 yang diproses
                    }
                }

                // Jika 'selesai' ATAU 'persetujuan' tapi belum ada data sama sekali (INSERT)
                $this->fileProsesModel->insert([
                    'id_persetujuan_magang' => $id_persetujuan,
                    'id_file'               => $this->request->getPost('id_file'),
                    'nama_file'             => $file->getClientName(),
                    'path_file'             => $path_file,
                    'proses_magang'         => $prosesMagang, // Dinamis
                    'created_by'            => session('id_user_pegawai')
                ]);
                $berhasil++;

                // Jika persetujuan, batasi max 1 file (hentikan loop foreach)
                if ($prosesMagang === 'persetujuan') {
                    break;
                }
            }
        }

        if ($berhasil > 0) {
            return $this->response->setJSON(['success' => true, 'message' => "$berhasil surat penerimaan berhasil diunggah."]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal mengunggah file. Pastikan format dan ukuran sesuai.']);
    }

    public function updateFile($id_file_selesai)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('sekretariat/riwayat'));
        }

        $existing = $this->fileProsesModel->find($id_file_selesai);
        if (!$existing) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak ditemukan.']);
        }

        $file = $this->request->getFile('file_baru');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak valid atau tidak dipilih.']);
        }

        $ext = $file->getClientExtension();
        $size = $file->getSize(); 
        if (!in_array(strtolower($ext), ['pdf', 'doc', 'docx'])) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format file tidak valid.']);
        }
        if ($size > 5120000) {
            return $this->response->setJSON(['success' => false, 'message' => 'Ukuran file melebihi 5MB.']);
        }

        // Hapus file fisik lama
        $oldPath = WRITEPATH . $existing->path_file;
        if (file_exists($oldPath) && is_file($oldPath)) {
            unlink($oldPath);
        }

        // Simpan file baru
        $newName = $file->getRandomName();
        $file->store('surat_penerimaan_magang/', $newName);
        $path_file = 'uploads/surat_penerimaan_magang/' . $newName;

        $this->fileProsesModel->update($id_file_selesai, [
            'nama_file'  => $file->getClientName(),
            'path_file'  => $path_file,
            'updated_by' => session('id_user_pegawai')
        ]);

        return $this->response->setJSON(['success' => true, 'message' => 'File berhasil diganti.']);
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

        $oldFilePath = WRITEPATH . $existing->path_file;
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
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Data file tidak ditemukan di database.');
        }

        $filePath = WRITEPATH . $fileData->path_file;
        if (!file_exists($filePath)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File fisik tidak ditemukan di server.');
        }

        return $this->response->download($filePath, null)->setFileName($fileData->nama_file);
    }
}
