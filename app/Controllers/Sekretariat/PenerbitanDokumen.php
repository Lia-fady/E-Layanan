<?php

namespace App\Controllers\Sekretariat;

use App\Controllers\BaseController;
use App\Models\FileProsesMagangModel;

/**
 * Controller Penerbitan Dokumen (Sertifikat & Surat Selesai Magang)
 */
class PenerbitanDokumen extends BaseController
{
    protected $fileModel;

    public function __construct()
    {
        $this->fileModel = new FileProsesMagangModel();
    }

    /**
     * Tampilkan daftar mahasiswa
     */
    public function index()
    {
        $listMahasiswa = $this->fileModel->getListMahasiswa();

        if (empty($listMahasiswa)) {
            $listMahasiswa = [
                [
                    'id_persetujuan_magang' => 1, 
                    'nama_mahasiswa' => 'Kusuma Wijaya',
                    'nim' => '10204230030',
                    'universitas' => 'Universitas Indonesia',
                    'prodi' => 'Sistem Informasi',
                    'tgl_mulai' => '2026-07-18',
                    'tgl_selesai' => '2026-08-31'
                ],
                [
                    'id_persetujuan_magang' => 2, 
                    'nama_mahasiswa' => 'Refa Psht',
                    'nim' => '10204230001',
                    'universitas' => 'Universitas Indonesia',
                    'prodi' => 'Sistem Informasi',
                    'tgl_mulai' => '2026-07-21',
                    'tgl_selesai' => '2026-09-19'
                ],
                [
                    'id_persetujuan_magang' => 3, 
                    'nama_mahasiswa' => 'Putra Wijaya',
                    'nim' => '102042330040',
                    'universitas' => 'Universitas Gadjah Mada',
                    'prodi' => 'Teknik Informatika',
                    'tgl_mulai' => '2026-07-24',
                    'tgl_selesai' => '2026-09-22'
                ]
            ];
        }

        $data = [
            'title'     => 'Penerbitan Dokumen',
            'mahasiswa' => $listMahasiswa
        ];

        return view('kabid/v_penerbitan_list', $data);
    }

    /**
     * Form detail upload untuk dokumen tertentu
     *
     * @param int $idPersetujuan ID persetujuan magang
     */
    public function detail($idPersetujuan)
    {
        $info = $this->fileModel->getInfoPermohonan((int) $idPersetujuan);

        if (empty($info)) {
            $info = [
                'id_persetujuan_magang' => $idPersetujuan,
                'nama_mahasiswa'        => 'Kusuma Wijaya',
                'nim'                   => '3671020222040010', // as NIK placeholder in photo
                'universitas'           => 'Universitas Indonesia',
                'prodi'                 => 'Sistem Informasi / Fakultas Ilmu Komputer',
                'jenis_permohonan'      => 'Magang / PKL',
                'tgl_pengajuan'         => '2026-07-18 05:22:00',
                'tgl_mulai'             => '2026-07-18',
                'tgl_selesai'           => '2026-08-31',
                'nama_bidang'           => 'Bidang Pengembangan E-Government',
                'deskripsi_magang'      => 'Pengembangan Aplikasi Berbasis Website',
                'id_file_permohonan'    => null,
            ];
        }

        $periode = '-';
        if (! empty($info['tgl_mulai']) && ! empty($info['tgl_selesai'])) {
            $periode = date('d M Y', strtotime($info['tgl_mulai'])) . ' s/d ' . date('d M Y', strtotime($info['tgl_selesai']));
        }

        // Cari dokumen yang sudah diupload
        $db = \Config\Database::connect();
        $files = $db->table('t_file_proses_magang')
                    ->where('id_persetujuan_magang', $idPersetujuan)
                    ->get()->getResultArray();

        $data = [
            'title'                 => 'Penerbitan Dokumen',
            'id_persetujuan_magang' => $idPersetujuan,
            'info'                  => $info,
            'periode'               => $periode,
            'files'                 => $files,
        ];

        return view('kabid/v_penerbitan_detail', $data);
    }

    /**
     * Proses upload file (AJAX)
     */
    public function upload()
    {
        $idPersetujuan = $this->request->getPost('id_persetujuan_magang');
        $jenisDokumen  = $this->request->getPost('jenis_dokumen'); // surat_keterangan atau sertifikat
        $catatan       = $this->request->getPost('catatan');

        if (! $idPersetujuan || ! $jenisDokumen) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);
        }

        $rules = [
            'file_dokumen' => [
                'rules'  => 'uploaded[file_dokumen]|mime_in[file_dokumen,application/pdf]|max_size[file_dokumen,2048]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file dokumen.',
                    'mime_in'  => 'Format file harus PDF.',
                    'max_size' => 'Ukuran file maksimal 2MB.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => implode('<br>', $this->validator->getErrors()),
            ]);
        }

        $file = $this->request->getFile('file_dokumen');
        if (! $file->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File upload gagal, silakan coba lagi.']);
        }

        $namaAsli   = $file->getClientName();
        $namaRandom = $file->getRandomName();
        $uploadPath = WRITEPATH . 'uploads/sertifikat';
        
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        try {
            $file->move($uploadPath, $namaRandom);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan file: ' . $e->getMessage()]);
        }

        $data = [
            'id_persetujuan_magang' => (int) $idPersetujuan,
            'id_file'               => (int) $this->request->getPost('id_file_permohonan'),
            'jenis_dokumen'         => $jenisDokumen,
            'catatan'               => $catatan,
            'nama_file'             => $namaAsli,
            'path_file'             => $namaRandom,
            'proses_magang'         => 'selesai',
            'created_at'            => date('Y-m-d H:i:s'),
            'created_by'            => session('id_user') ?? 1,
            'updated_at'            => date('Y-m-d H:i:s'),
            'updated_by'            => session('id_user') ?? 1,
        ];

        $ok = $this->fileModel->simpanSertifikat($data);

        if ($ok) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Dokumen berhasil diunggah!']);
        }

        @unlink($uploadPath . '/' . $namaRandom);
        return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal menyimpan data ke database.']);
    }

    /**
     * Ganti file (AJAX)
     */
    public function gantiFile()
    {
        $idFile = $this->request->getPost('id_file_selesai_magang');
        
        if (! $idFile) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Parameter tidak lengkap.']);
        }

        $rules = [
            'file_dokumen' => [
                'rules'  => 'uploaded[file_dokumen]|mime_in[file_dokumen,application/pdf]|max_size[file_dokumen,2048]',
                'errors' => [
                    'uploaded' => 'Silakan pilih file.',
                    'mime_in'  => 'Format file harus PDF.',
                    'max_size' => 'Ukuran file maksimal 2MB.',
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON(['status' => 'error', 'message' => implode('<br>', $this->validator->getErrors())]);
        }

        // Cari data sertifikat lama
        $existing = $this->fileModel->find((int)$idFile);

        if (! $existing) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan.']);
        }

        $file = $this->request->getFile('file_dokumen');
        if (! $file->isValid()) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File upload gagal, silakan coba lagi.']);
        }

        $uploadPath = WRITEPATH . 'uploads/sertifikat';
        $namaAsli   = $file->getClientName();
        $namaRandom = $file->getRandomName();

        try {
            $file->move($uploadPath, $namaRandom);
            $fileLama = $uploadPath . '/' . $existing['path_file'];
            if (file_exists($fileLama)) {
                unlink($fileLama);
            }

            $ok = $this->fileModel->update($existing['id_file_selesai_magang'], [
                'nama_file'  => $namaAsli,
                'path_file'  => $namaRandom,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => session('id_user') ?? 1,
            ]);

            if ($ok) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Dokumen berhasil diganti!']);
            }
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memperbarui data di database.']);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal mengganti file: ' . $e->getMessage()]);
        }
    }

    public function lihat($id)
    {
        $data = $this->fileModel->find((int) $id);
        if (! $data) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Dokumen tidak ditemukan.');

        $filePath = WRITEPATH . 'uploads/sertifikat/' . $data['path_file'];
        if (! file_exists($filePath)) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan.');

        return $this->response->setHeader('Content-Type', 'application/pdf')
                              ->setHeader('Content-Disposition', 'inline; filename="' . $data['nama_file'] . '"')
                              ->setBody(file_get_contents($filePath));
    }

    public function download($id)
    {
        $data = $this->fileModel->find((int) $id);
        if (! $data) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Dokumen tidak ditemukan.');

        $filePath = WRITEPATH . 'uploads/sertifikat/' . $data['path_file'];
        if (! file_exists($filePath)) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('File tidak ditemukan.');

        return $this->response->download($filePath, null)->setFileName($data['nama_file']);
    }

    /**
     * Hapus file sertifikat/surat keterangan
     */
    public function hapus_file($idFileSelesaiMagang)
    {
        $db = \Config\Database::connect();
        $file = $db->table('t_file_proses_magang')->where('id_file_selesai_magang', $idFileSelesaiMagang)->get()->getRowArray();
        
        if (!$file) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'File tidak ditemukan.']);
        }

        // Hapus file fisik jika ada
        $path = WRITEPATH . 'uploads/sertifikat/' . $file['path_file'];
        if (file_exists($path)) {
            unlink($path);
        } else {
            $pathOld = WRITEPATH . 'uploads/' . $file['path_file'];
            if (file_exists($pathOld)) {
                unlink($pathOld);
            }
        }

        // Hapus data dari database
        $db->table('t_file_proses_magang')->where('id_file_selesai_magang', $idFileSelesaiMagang)->delete();

        return $this->response->setJSON(['status' => 'success', 'message' => 'File berhasil dihapus!']);
    }
}
