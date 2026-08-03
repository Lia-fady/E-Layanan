<?php

namespace App\Controllers\Mahasiswa;

class C_Logbook_Mahasiswa extends C_Base_Mahasiswa
{
    public function logbook()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $penempatan = $this->logbookModel->cekPenempatanAktif($id_mahasiswa);

        $riwayatLogbook = [];
        if ($penempatan) {
            $id_penempatan = $penempatan['id_penempatan_magang'];

            $filterPeriode = $this->request->getGet('filter_periode');
            $filterStatus  = $this->request->getGet('filter_status');

            $builder = $this->logbookModel
                ->where('id_penempatan_magang', $id_penempatan);

            if ($filterPeriode === 'bulan_ini') {
                $builder->where('MONTH(tgl_logbook)', date('m'))
                        ->where('YEAR(tgl_logbook)', date('Y'));
            } elseif ($filterPeriode === 'minggu_ini') {
                $builder->where('tgl_logbook >=', date('Y-m-d', strtotime('monday this week')))
                        ->where('tgl_logbook <=', date('Y-m-d', strtotime('sunday this week')));
            }

            if ($filterStatus === 'pending') {
                $builder->where('disetujui_oleh IS NULL', null, false);
            } elseif ($filterStatus === 'disetujui') {
                $builder->where('disetujui_oleh IS NOT NULL', null, false);
            }

            $riwayatLogbook = $builder->orderBy('tgl_logbook', 'DESC')->findAll();
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);

        $data = [
            'title'            => 'Logbook & Absensi Magang',
            'nama'             => session()->get('nama') ?? 'Mahasiswa',
            'penempatan'       => $penempatan, 
            'logbook'          => $riwayatLogbook,
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan']
        ];

        return view('dashboard/mahasiswa/v_riwayat_logbook', $data);
    }

    public function simpanLogbook()
    {
        $id_mahasiswa = session()->get('id_mahasiswa'); 
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $penempatan = $this->logbookModel->cekPenempatanAktif($id_mahasiswa);

        if (!$penempatan) {
            return redirect()->back()->with('error', 'Gagal menyimpan! Anda belum dialokasikan ke bidang manapun.');
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        if (isset($stateData['is_log_book']) && strtolower($stateData['is_log_book']) == 'tidak') {
            return redirect()->back()->with('error', 'Gagal menyimpan! Kegiatan magang Anda tidak mewajibkan pengisian logbook.');
        }

        if (isset($penempatan['status_penempatan']) && $penempatan['status_penempatan'] == 'SELESAI') {
            return redirect()->back()->with('error', 'Gagal menyimpan! Masa kegiatan magang Anda telah berakhir.');
        }

        $dataLogbook = [
            'id_penempatan_magang' => $penempatan['id_penempatan_magang'], 
            'tgl_logbook'          => $this->request->getPost('tgl_logbook'),
            'logbook_magang'       => $this->request->getPost('logbook_magang'),
            'created_at'           => date('Y-m-d H:i:s')
        ];

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

        return view('dashboard/mahasiswa/v_cetak_logbook', $data);
    }
}
