<?php

namespace App\Controllers\Mahasiswa;

class C_Sertifikat extends C_BaseMahasiswa
{
    public function sertifikat()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $penempatan = $this->penempatanModel->getPenempatanDetail($id_mahasiswa);
        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        $db = \Config\Database::connect();

        $approvals = $db->table('t_persetujuan_magang ps')
            ->select('ps.id_persetujuan_magang, ps.tanggal_persetujuan as tgl_persetujuan, ps.status_persetujuan, pm.tgl_mulai, pm.tgl_selesai, pm.id_jenis_permohonan, jp.jenis_permohonan, pnm.status_penempatan, bidang.bidang')
            ->join('t_permohonan_magang pm', 'pm.id_permohonan_magang = ps.id_permohonan_magang', 'left')
            ->join('m_jenis_permohonan jp', 'jp.id_jenis_permohonan = pm.id_jenis_permohonan', 'left')
            ->join('t_penempatan_magang pnm', 'pnm.id_persetujuan_magang = ps.id_persetujuan_magang', 'left')
            ->join('m_bidang bidang', 'bidang.id_bidang = ps.id_bidang', 'left')
            ->where('pm.id_mahasiswa', $id_mahasiswa)
            ->whereIn('pnm.status_penempatan', ['BERJALAN', 'SELESAI'])
            ->orderBy('ps.tanggal_persetujuan', 'DESC')
            ->get()->getResultArray();

        $listJenis = $db->table('m_jenis_permohonan')
            ->orderBy('id_jenis_permohonan', 'ASC')
            ->get()->getResultArray();

        $documentGroups = [];
        foreach ($approvals as $approval) {
            $files = $db->table('t_file_proses_magang fp')
                ->select('fp.*, m_file.nama_file as nama_file_master, c_user_pegawai.nama as pengunggah')
                ->join('m_file', 'm_file.id_file = fp.id_file', 'left')
                ->join('c_user_pegawai', 'c_user_pegawai.id_user_pegawai = fp.created_by', 'left')
                ->where('fp.id_persetujuan_magang', $approval['id_persetujuan_magang'])
                ->orderBy('fp.created_at', 'DESC')
                ->get()->getResultArray();

            $groupedDocs = [
                'surat_penerimaan' => null,
                'surat_selesai'    => null,
                'piagam'           => null,
            ];

            foreach ($files as $file) {
                if ($file['id_file'] == 8) {
                    $groupedDocs['surat_penerimaan'] = $file;
                }
                if ($file['id_file'] == 9) {
                    $groupedDocs['surat_selesai'] = $file;
                }
                if ($file['id_file'] == 10) {
                    $groupedDocs['piagam'] = $file;
                }
            }

            $documentGroups[] = [
                'id_persetujuan_magang' => $approval['id_persetujuan_magang'],
                'jenis_permohonan'      => $approval['jenis_permohonan'] ?? 'Permohonan',
                'tgl_mulai'             => $approval['tgl_mulai'],
                'tgl_selesai'           => $approval['tgl_selesai'],
                'status_penempatan'     => $approval['status_penempatan'] ?? 'MENUNGGU',
                'status_persetujuan'    => $approval['status_persetujuan'] ?? 'MENUNGGU',
                'bidang'                => $approval['bidang'] ?? '-',
                'docs'                  => $groupedDocs,
            ];
        }

        $data = [
            'title'            => 'Dokumen Kegiatan',
            'nama'             => session()->get('nama_mahasiswa') ?? 'Mahasiswa',
            'penempatan'       => $penempatan,
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan'],
            'documentGroups'   => $documentGroups,
            'list_jenis'       => $listJenis,
        ];

        return view('mahasiswa/v_unduh_sertifikat', $data);
    }

    public function serveFile($id_file_selesai)
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();
        $file = $db->table('t_file_proses_magang')
                   ->where('id_file_proses_magang', $id_file_selesai)
                   ->get()->getRowArray();
                   
        if (!$file) {
            return redirect()->to(base_url('mahasiswa/sertifikat'))->with('error', 'Data file tidak ditemukan.');
        }

        $filePath = FCPATH . $file['path_file'];
        if (!file_exists($filePath)) {
            $filePath = WRITEPATH . $file['path_file'];
        }

        if (file_exists($filePath)) {
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
            $contentType = 'application/pdf';
            if (in_array(strtolower($ext), ['png', 'jpg', 'jpeg'])) {
                $contentType = 'image/' . $ext;
            }

            header("Content-Type: " . $contentType);
            
            if ($this->request->getGet('action') == 'download') {
                header("Content-Disposition: attachment; filename=\"" . basename($filePath) . "\"");
            } else {
                header("Content-Disposition: inline; filename=\"" . basename($filePath) . "\"");
            }
            
            header("Content-Length: " . filesize($filePath));
            readfile($filePath);
            exit;
        }

        return redirect()->to(base_url('mahasiswa/sertifikat'))->with('error', 'File fisik tidak ditemukan di server.');
    }
}

