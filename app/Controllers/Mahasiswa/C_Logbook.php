<?php

namespace App\Controllers\Mahasiswa;

class C_Logbook extends C_BaseMahasiswa
{
    public function logbook()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        // Get all placements for dropdown context switcher
        $semuaPenempatan = $this->logbookModel->getSemuaPenempatan($id_mahasiswa);
        
        $penempatan = null;
        if (!empty($semuaPenempatan)) {
            // Default to the first (latest) placement
            $penempatan = $semuaPenempatan[0];
            // Cek jika ada POST request untuk ganti penempatan (AJAX / JS)
            $req_id_penempatan = $this->request->getPost('id_penempatan') ?? $this->request->getGet('id_penempatan');
            if ($req_id_penempatan) {
                foreach ($semuaPenempatan as $p) {
                    if ($p['id_penempatan_magang'] == $req_id_penempatan) {
                        $penempatan = $p;
                        break;
                    }
                }
            }
        }

        // Ambil SEMUA logbook tanpa filter server-side — biar client-side yang handle
        $riwayatLogbook = [];
        if ($penempatan) {
            $riwayatLogbook = $this->logbookModel
                ->where('id_penempatan_magang', $penempatan['id_penempatan_magang'])
                ->orderBy('tgl_logbook', 'DESC')
                ->findAll();
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        $data = [
            'title'            => 'Logbook & Absensi Magang',
            'nama'             => session()->get('nama') ?? 'Mahasiswa',
            'penempatan'       => $penempatan, 
            'semuaPenempatan'  => $semuaPenempatan,
            'logbook'          => $riwayatLogbook,
            'state'            => $stateData['state'],
            'is_log_book'      => $penempatan ? ($penempatan['is_log_book'] ?? 'tidak') : $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan']
        ];

        return view('mahasiswa/v_riwayat_logbook', $data);
    }

    public function simpanLogbook()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $id_penempatan_post = $this->request->getPost('id_penempatan_magang');
        if (!$id_penempatan_post) {
             return redirect()->back()->with('error', 'Gagal menyimpan! ID Penempatan tidak valid.');
        }

        $penempatanCheck = $this->logbookModel->db->table('t_penempatan_magang')->where('id_penempatan_magang', $id_penempatan_post)->get()->getRowArray();
        if ($penempatanCheck && isset($penempatanCheck['is_log_book']) && strtolower($penempatanCheck['is_log_book']) == 'tidak') {
            return redirect()->back()->with('error', 'Gagal menyimpan! Kegiatan magang Anda tidak mewajibkan pengisian logbook.');
        }

        $dataLogbook = [
            'id_penempatan_magang' => $id_penempatan_post, 
            'tgl_logbook'          => $this->request->getPost('tgl_logbook'),
            'logbook_magang'       => $this->request->getPost('logbook_magang'),
            'created_at'           => date('Y-m-d H:i:s')
        ];

        $fileBukti = $this->request->getFile('bukti_kegiatan');
        if ($fileBukti && $fileBukti->isValid() && !$fileBukti->hasMoved()) {
            $newName = $fileBukti->getRandomName();
            $fileBukti->move(ROOTPATH . 'public/uploads/logbook', $newName);
            $dataLogbook['bukti_kegiatan'] = 'uploads/logbook/' . $newName;
        }

        $this->logbookModel->insert($dataLogbook);

        return redirect()->to(base_url('mahasiswa/logbook'))->with('success', 'Logbook harian berhasil disimpan!');
    }

    public function cetakLogbook()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $penempatan = $this->logbookModel->cekPenempatanAktif($id_mahasiswa);
        if (!$penempatan) {
            return redirect()->to(base_url('mahasiswa/logbook'))->with('error', 'Tidak ada data penempatan aktif.');
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        
        $builder = $this->logbookModel->where('id_penempatan_magang', $penempatan['id_penempatan_magang']);
        $builder->where('disetujui_oleh IS NOT NULL', null, false);
        $logbookDisetujui = $builder->orderBy('tgl_logbook', 'ASC')->findAll();
        
        $db = \Config\Database::connect();
        $detailMhs = $db->table('m_mahasiswa')
            ->select('m_mahasiswa.*, m_instansi_pendidikan.instansi_pendidikan')
            ->join('t_instansi_mahasiswa', 't_instansi_mahasiswa.id_mahasiswa = m_mahasiswa.id_mahasiswa', 'left')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->where('m_mahasiswa.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        $data = [
            'title'      => 'Cetak Logbook Kegiatan',
            'penempatan' => $penempatan,
            'mhs'        => $detailMhs,
            'logbook'    => $logbookDisetujui,
            'jenis_permohonan' => $stateData['jenis_permohonan']
        ];

        return view('mahasiswa/v_cetak_logbook', $data);
    }
}
