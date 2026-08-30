<?php

namespace App\Controllers\Mahasiswa;

class C_Status extends C_BaseMahasiswa
{
    public function statusPermohonan()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }
        
        // Menggunakan DOM DataTables, ambil semua permohonan milik mahasiswa ini
        $builder = $this->permohonanModel->getStatusPermohonan($id_mahasiswa, null);
        $queryPermohonan = $builder
            ->orderBy('t_permohonan_magang.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $db = \Config\Database::connect();
        foreach ($queryPermohonan as &$p) {
            $p['files'] = $db->table('t_file_permohonan_magang')
                ->select('t_file_permohonan_magang.id_file_permohonan_magang, m_file.nama_file, t_file_permohonan_magang.path_file')
                ->join('m_file_permohonan', 'm_file_permohonan.id_file_permohonan = t_file_permohonan_magang.id_file_permohonan', 'left')
                ->join('m_file', 'm_file.id_file = m_file_permohonan.id_file', 'left')
                ->where('t_file_permohonan_magang.id_permohonan_magang', $p['id_permohonan_magang'])
                ->orderBy('m_file.id_file', 'ASC')
                ->get()->getResultArray();
                
            // Ambil surat balasan / penerimaan dari sekretariat
            if (!empty($p['id_persetujuan_magang'])) {
                $p['surat_balasan'] = $db->table('t_file_proses_magang')
                    ->where('id_persetujuan_magang', $p['id_persetujuan_magang'])
                    ->where('proses_magang', 'persetujuan')
                    ->get()->getResultArray();
            } else {
                $p['surat_balasan'] = [];
            }
        }
        unset($p); 

        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        $data = [
            'title'            => 'Status Permohonan Magang',
            'nama'             => session()->get('nama') ?? 'Mahasiswa',
            'permohonan'       => $queryPermohonan,
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan']
        ];

        return view('mahasiswa/v_status_permohonan', $data);
    }

    public function detail($id_permohonan)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $builder = $this->permohonanModel->getStatusPermohonan($id_mahasiswa, null);
        $p = $builder->where('t_permohonan_magang.id_permohonan_magang', $id_permohonan)->get()->getRowArray();
        
        if (!$p) {
            session()->setFlashdata('error', 'Data permohonan tidak ditemukan atau Anda tidak memiliki akses.');
            return redirect()->to(base_url('mahasiswa/status'));
        }

        $db = \Config\Database::connect();
        $p['files'] = $db->table('t_file_permohonan_magang')
            ->select('t_file_permohonan_magang.id_file_permohonan_magang, m_file.nama_file, t_file_permohonan_magang.path_file, t_file_permohonan_magang.status_verifikasi')
            ->join('m_file_permohonan', 'm_file_permohonan.id_file_permohonan = t_file_permohonan_magang.id_file_permohonan', 'left')
            ->join('m_file', 'm_file.id_file = m_file_permohonan.id_file', 'left')
            ->where('t_file_permohonan_magang.id_permohonan_magang', $p['id_permohonan_magang'])
            ->orderBy('m_file.id_file', 'ASC')
            ->get()->getResultArray();

        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        $data = [
            'title'            => 'Detail Permohonan Magang',
            'nama'             => session()->get('nama') ?? 'Mahasiswa',
            'p'                => $p,
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan']
        ];

        return view('mahasiswa/v_detail_permohonan', $data);
    }

    public function batalkanPermohonan($id_permohonan)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        
        $permohonan = $db->table('t_permohonan_magang')
                         ->where('id_permohonan_magang', $id_permohonan)
                         ->where('id_mahasiswa', $id_mahasiswa)
                         ->get()->getRowArray();
                         
        if (!$permohonan) {
            session()->setFlashdata('error', 'Permohonan tidak ditemukan.');
            return redirect()->to(base_url('mahasiswa/status'));
        }

        $cekStatus = $db->table('t_persetujuan_magang')->where('id_permohonan_magang', $id_permohonan)->get()->getRowArray();

        if (!empty($cekStatus) && in_array($cekStatus['status_persetujuan'], ['DISETUJUI', 'DITOLAK'])) {
            session()->setFlashdata('error', 'Permohonan tidak dapat dibatalkan karena sudah diproses oleh tim verifikator.');
            return redirect()->to(base_url('mahasiswa/status'));
        }

        $pesan_sukses = '';

        $db->transStart();
        // Hapus file fisik
        $fileRecords = $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->get()->getResultArray();
        foreach ($fileRecords as $file) {
            $filePath = FCPATH . $file['path_file'];
            if (file_exists($filePath) && is_file($filePath)) {
                unlink($filePath);
            }
        }
        
        // Hapus data file di database
        $db->table('t_file_permohonan_magang')->where('id_permohonan_magang', $id_permohonan)->delete();
        
        // Hapus data persetujuan jika ada (misal status PERBAIKAN_BERKAS)
        $db->table('t_persetujuan_magang')->where('id_permohonan_magang', $id_permohonan)->delete();
        
        // Hapus data permohonan utama
        $this->permohonanModel->where('id_permohonan_magang', $id_permohonan)->where('id_mahasiswa', $id_mahasiswa)->delete();
        
        // Hapus log sistem
        $db->table('t_log_permohonan')->where('id_permohonan_magang', $id_permohonan)->delete();
        
        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            session()->setFlashdata('error', 'Gagal membatalkan permohonan magang, terjadi kesalahan database.');
        } else {
            session()->setFlashdata('success', 'Permohonan magang Anda berhasil dibatalkan.');
        }
        return redirect()->to(base_url('mahasiswa/status'));
    }

    public function setujuiPeriode($id_permohonan)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $persetujuan = $db->table('t_persetujuan_magang')
                          ->where('id_permohonan_magang', $id_permohonan)
                          ->get()->getRowArray();

        if (!$persetujuan) {
            session()->setFlashdata('error', 'Data persetujuan tidak ditemukan.');
            return redirect()->to(base_url('mahasiswa/status'));
        }

        // Validate that Mahasiswa owns this permohonan
        $permohonan = $this->permohonanModel->where('id_permohonan_magang', $id_permohonan)
                                            ->where('id_mahasiswa', $id_mahasiswa)
                                            ->first();
        if (!$permohonan) {
            session()->setFlashdata('error', 'Permohonan tidak ditemukan.');
            return redirect()->to(base_url('mahasiswa/status'));
        }

        $db->table('t_persetujuan_magang')
           ->where('id_permohonan_magang', $id_permohonan)
           ->update(['status_persetujuan_mahasiswa' => 'DISETUJUI']);
           
        // Also update penempatan status to BERJALAN if today >= tgl_mulai_disetujui, else DISETUJUI
        $today = date('Y-m-d');
        $tgl_mulai = $persetujuan['tgl_mulai_disetujui'] ?? $permohonan['tgl_mulai'];
        
        $statusPenempatan = ($tgl_mulai <= $today) ? 'BERJALAN' : 'DISETUJUI';
        
        $db->table('t_penempatan_magang')
           ->where('id_persetujuan_magang', $persetujuan['id_persetujuan_magang'])
           ->update(['status_penempatan' => $statusPenempatan]);

        session()->setFlashdata('success', 'Periode magang berhasil disetujui. Silakan cek menu Logbook.');
        return redirect()->to(base_url('mahasiswa/status'));
    }

    public function viewFile($param1, $param2 = null)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();

        if ($param2 === null) {
            $fileData = $db->table('t_file_permohonan_magang')
                ->select('t_file_permohonan_magang.*')
                ->join('t_permohonan_magang', 't_permohonan_magang.id_permohonan_magang = t_file_permohonan_magang.id_permohonan_magang')
                ->where('t_file_permohonan_magang.id_file_permohonan_magang', $param1)
                ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
                ->get()->getRowArray();
        } else {
            $listFiles = $db->table('t_file_permohonan_magang')
                ->select('t_file_permohonan_magang.*')
                ->join('t_permohonan_magang', 't_permohonan_magang.id_permohonan_magang = t_file_permohonan_magang.id_permohonan_magang')
                ->where('t_file_permohonan_magang.id_permohonan_magang', $param1)
                ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
                ->orderBy('t_file_permohonan_magang.id_file_permohonan', 'ASC') 
                ->get()->getResultArray();
            $index    = ($param2 == 'surat' || $param2 == '1') ? 0 : 1;
            $fileData = $listFiles[$index] ?? null;
        }

        if (!empty($fileData)) {
            $filePath = FCPATH . $fileData['path_file']; 
            if (file_exists($filePath)) {
                header("Content-Type: application/pdf");
                header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
                header("Content-Length: " . filesize($filePath));
                readfile($filePath);
                exit;
            }
        }

        session()->setFlashdata('error', 'Berkas PDF fisik tidak ditemukan di direktori server.');
        return redirect()->to(base_url('mahasiswa/status'));
    }

    public function downloadSuratPenerimaan($id_file_selesai)
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $fileData = $db->table('t_file_proses_magang')
            ->select('t_file_proses_magang.*')
            ->join('t_persetujuan_magang', 't_persetujuan_magang.id_persetujuan_magang = t_file_proses_magang.id_persetujuan_magang')
            ->join('t_permohonan_magang', 't_permohonan_magang.id_permohonan_magang = t_persetujuan_magang.id_permohonan_magang')
            ->where('t_file_proses_magang.id_file_proses_magang', $id_file_selesai)
            ->where('t_file_proses_magang.proses_magang', 'persetujuan')
            ->where('t_permohonan_magang.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        if (!empty($fileData)) {
            $filePath = WRITEPATH . $fileData['path_file']; 
            if (file_exists($filePath)) {
                $ext = pathinfo($filePath, PATHINFO_EXTENSION);
                $contentType = ($ext === 'pdf') ? 'application/pdf' : 'application/octet-stream';
                
                header("Content-Type: " . $contentType);
                header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
                header("Content-Length: " . filesize($filePath));
                readfile($filePath);
                exit;
            }
        }

        session()->setFlashdata('error', 'Berkas Surat Penerimaan tidak ditemukan di direktori server.');
        return redirect()->to(base_url('mahasiswa/status'));
    }
}

