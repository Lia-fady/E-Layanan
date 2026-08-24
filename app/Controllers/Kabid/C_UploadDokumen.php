<?php
namespace App\Controllers\Kabid;

use App\Controllers\BaseController;
use App\Models\Sekretariat\M_File;
use App\Models\Sekretariat\M_FileProsesMagang;

class C_UploadDokumen extends BaseController
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
        if ($this->request->isAJAX() && $this->request->getPost('action') === 'get_detail') {
            $id_persetujuan = $this->request->getPost('id');
            $persetujuan = $this->getPersetujuanDetail($id_persetujuan);
            
            if (!$persetujuan) {
                return "Data persetujuan tidak ditemukan.";
            }

            if (!in_array($persetujuan->status_penempatan, ['BERJALAN', 'SELESAI'])) {
                return "Mahasiswa belum disetujui atau status belum aktif.";
            }

            $data = [
                'persetujuan' => $persetujuan,
                'jenis_file'  => $this->fileModel->whereIn('nama_file', ['File Surat Keterangan Diterima Magang', 'File Sertifikat', 'File Surat Keterangan Selesai Magang'])->where('status_aktif', '1')->findAll(),
                'files'       => $this->fileProsesModel->getSuratByPersetujuan($id_persetujuan),
            ];

            return view('dashboard/kabid/v_upload_dokumen', $data);
        }

        $db = \Config\Database::connect();
        
        $builder = $db->table('t_persetujuan_magang ps')
            ->select('ps.*, pm.tgl_mulai, pm.tgl_selesai, mhs.nama_mahasiswa, mhs.nim, ip.instansi_pendidikan, pr.prodi, jp.jenis_permohonan, pnm.status_penempatan')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left')
            ->join('m_mahasiswa mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi', 'left')
            ->join('m_jenis_permohonan jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left')
            ->join('t_penempatan_magang pnm', 'pnm.id_persetujuan_magang = ps.id_persetujuan_magang', 'left')
            ->where('ps.status_persetujuan', 'DISETUJUI')
            ->orderBy('ps.tgl_persetujuan', 'DESC');
            
        $builder->groupStart()
            ->where('pnm.status_penempatan', 'BERJALAN')
            ->orWhere('pnm.status_penempatan', 'SELESAI')
        ->groupEnd();
            
        if (session()->has('id_bidang')) {
             $builder->where('ps.id_bidang', session('id_bidang'));
        }

        $persetujuan = $builder->get()->getResult();
        $list_jenis = $db->table('m_jenis_permohonan')->get()->getResultArray();

        $data = [
            'title'       => 'Daftar Dokumen Kegiatan',
            'active_menu' => 'upload_dokumen',
            'persetujuan' => $persetujuan,
            'list_jenis'  => $list_jenis,
            'search'      => null,
            'jenis_permohonan' => null,
            'status_penempatan' => null
        ];

        return view('dashboard/kabid/v_upload_dokumen_index', $data);
    }

    private function getPersetujuanDetail($id_persetujuan)
    {
        $db = \Config\Database::connect();
        return $db->table('t_persetujuan_magang ps')
            ->select('ps.*, pm.tgl_mulai, pm.tgl_selesai, mhs.nama_mahasiswa, mhs.nim, ip.instansi_pendidikan, pr.prodi, pnm.status_penempatan')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left')
            ->join('m_mahasiswa mhs', 'mhs.id_mahasiswa = pm.id_mahasiswa', 'left')
            ->join('t_instansi_mahasiswa im', 'im.id_instansi_mahasiswa = pm.id_instansi_mahasiswa', 'left')
            ->join('m_instansi_pendidikan ip', 'ip.id_instansi_pendidikan = im.id_instansi_pendidikan', 'left')
            ->join('m_prodi pr', 'pr.id_prodi = im.id_prodi', 'left')
            ->join('t_penempatan_magang pnm', 'pnm.id_persetujuan_magang = ps.id_persetujuan_magang', 'left')
            ->where('ps.id_persetujuan_magang', $id_persetujuan)
            ->get()->getRow();
    }

    // public function form dihapus karena digantikan oleh AJAX get_detail di index()

    public function store()
    {
        $validationRules = [
            'id_persetujuan_magang' => 'required',
            'id_file'               => 'required',
            'file_surat'            => [
                'rules'  => 'uploaded[file_surat]|max_size[file_surat,5120]|ext_in[file_surat,pdf,doc,docx]|mime_in[file_surat,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file terlebih dahulu.',
                    'max_size' => 'Ukuran file maksimal 5 MB.',
                    'ext_in'   => 'Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.',
                    'mime_in'  => 'Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return $this->response->setJSON(['success' => false, 'message' => implode('<br>', $this->validator->getErrors())]);
        }

        $id_persetujuan = $this->request->getPost('id_persetujuan_magang');
        
        // Pengecekan apakah id_persetujuan_magang valid dan ada di tabel t_persetujuan_magang
        $db = \Config\Database::connect();
        $cekPersetujuan = $db->table('t_persetujuan_magang')
                             ->where('id_persetujuan_magang', $id_persetujuan)
                             ->get()->getRow();
                             
        if (!$cekPersetujuan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data persetujuan magang tidak valid atau tidak ditemukan.']);
        }

        $id_file = $this->request->getPost('id_file');
        $existing = $this->fileProsesModel->getExistingSurat($id_persetujuan, $id_file);
        if ($existing) {
            return $this->response->setJSON(['success' => false, 'message' => 'Dokumen jenis ini sudah ada. Gunakan tombol Ganti File jika ingin mengubahnya.']);
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
                'proses_magang'         => 'SURAT_KETERANGAN_DITERIMA',
                'created_by'            => session('id_user_pegawai')
            ]);

            return $this->response->setJSON(['success' => true, 'message' => 'Surat keterangan diterima berhasil diunggah.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Dokumen gagal diunggah. Silakan coba lagi.']);
    }

    public function storeMulti()
    {
        $id_persetujuan = $this->request->getPost('id_persetujuan_magang');

        if (empty($id_persetujuan)) {
            return $this->response->setJSON(['success' => false, 'message' => 'ID persetujuan magang tidak valid.']);
        }

        // Validasi keberadaan data persetujuan
        $db = \Config\Database::connect();
        $cekPersetujuan = $db->table('t_persetujuan_magang')
                             ->where('id_persetujuan_magang', $id_persetujuan)
                             ->get()->getRow();

        if (!$cekPersetujuan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Data persetujuan magang tidak valid atau tidak ditemukan.']);
        }

        // Daftar slot file yang dikirim: file_0, file_1, file_2
        $allowedExt  = ['pdf', 'doc', 'docx'];
        $allowedMime = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        $maxSize     = 5120; // KB
        $storagePath = 'surat_penerimaan_magang/';

        $errors      = [];
        $savedCount  = 0;

        for ($i = 0; $i <= 2; $i++) {
            $file   = $this->request->getFile('file_' . $i);
            $id_file = $this->request->getPost('id_file_' . $i);

            // Lewati slot yang tidak ada file-nya
            if (!$file || !$file->isValid() || $file->hasMoved()) {
                continue;
            }

            // Validasi ukuran (getSize() dalam bytes)
            if ($file->getSize() > ($maxSize * 1024)) {
                $errors[] = "File ke-" . ($i + 1) . ": Ukuran file melebihi 5 MB.";
                continue;
            }

            // Validasi ekstensi
            $ext = strtolower($file->getClientExtension());
            if (!in_array($ext, $allowedExt)) {
                $errors[] = "File ke-" . ($i + 1) . ": Format tidak didukung. Gunakan PDF, DOC, atau DOCX.";
                continue;
            }

            // Validasi MIME
            $mime = $file->getMimeType();
            if (!in_array($mime, $allowedMime)) {
                $errors[] = "File ke-" . ($i + 1) . ": Format MIME tidak didukung.";
                continue;
            }

            if (empty($id_file)) {
                $errors[] = "File ke-" . ($i + 1) . ": ID jenis dokumen tidak ditemukan.";
                continue;
            }

            // Simpan file fisik
            $newName = $file->getRandomName();
            $file->store($storagePath, $newName);
            $path_file = 'uploads/' . $storagePath . $newName;

            // Cek apakah dokumen ini sudah ada di DB
            $existing = $this->fileProsesModel->getExistingSurat($id_persetujuan, $id_file);

            if ($existing) {
                // Hapus file fisik lama
                $oldPath = WRITEPATH . $existing->path_file;
                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
                // Update record
                $this->fileProsesModel->update($existing->id_file_selesai_magang, [
                    'nama_file'  => $file->getClientName(),
                    'path_file'  => $path_file,
                    'updated_by' => session('id_user_pegawai')
                ]);
            } else {
                // Insert record baru
                $this->fileProsesModel->insert([
                    'id_persetujuan_magang' => $id_persetujuan,
                    'id_file'               => $id_file,
                    'nama_file'             => $file->getClientName(),
                    'path_file'             => $path_file,
                    'proses_magang'         => 'SURAT_KETERANGAN_DITERIMA',
                    'created_by'            => session('id_user_pegawai')
                ]);
            }

            $savedCount++;
        }

        // Kembalikan respons
        if (!empty($errors) && $savedCount === 0) {
            return $this->response->setJSON([
                'success' => false,
                'message' => implode('<br>', $errors)
            ]);
        }

        $message = 'Dokumen berhasil disimpan.';
        if (!empty($errors)) {
            $message .= ' Namun terdapat masalah: ' . implode('; ', $errors);
        }

        return $this->response->setJSON(['success' => true, 'message' => $message]);
    }

    public function update($id_file_selesai)
    {
        $validationRules = [
            'id_file'    => 'required',
            'file_surat' => [
                'rules'  => 'uploaded[file_surat]|max_size[file_surat,5120]|ext_in[file_surat,pdf,doc,docx]|mime_in[file_surat,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file terlebih dahulu.',
                    'max_size' => 'Ukuran file maksimal 5 MB.',
                    'ext_in'   => 'Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.',
                    'mime_in'  => 'Format file tidak didukung. Gunakan PDF, DOC, atau DOCX.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return $this->response->setJSON(['success' => false, 'message' => implode('<br>', $this->validator->getErrors())]);
        }

        $existing = $this->fileProsesModel->find($id_file_selesai);
        if (!$existing) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak ditemukan.']);
        }

        $file = $this->request->getFile('file_surat');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->store('surat_penerimaan_magang/', $newName);
            $path_file = 'uploads/surat_penerimaan_magang/' . $newName;

            // Hapus file lama jika ada
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

            return $this->response->setJSON(['success' => true, 'message' => 'Dokumen berhasil diganti.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Dokumen gagal diunggah. Silakan coba lagi.']);
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

    public function delete($id_file_selesai)
    {
        $existing = $this->fileProsesModel->find($id_file_selesai);
        if (!$existing) {
            return $this->response->setJSON(['success' => false, 'message' => 'File tidak ditemukan.']);
        }

        $filePath = WRITEPATH . $existing->path_file;
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath);
        }

        $this->fileProsesModel->delete($id_file_selesai);
        return $this->response->setJSON(['success' => true, 'message' => 'Dokumen berhasil dihapus.']);
    }
}
