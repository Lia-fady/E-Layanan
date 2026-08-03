<?php

namespace App\Controllers\Mahasiswa;

class C_Profil_Mahasiswa extends C_Base_Mahasiswa
{
    public function profil()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'))->with('error', 'Silakan login terlebih dahulu.');
        }

        $stateData = $this->_getMahasiswaState($id_mahasiswa);
        $db = \Config\Database::connect();
        
        // Data Pribadi Mahasiswa
        $mahasiswa = $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRowArray();
        
        // Data Akademik + join ke m_instansi_pendidikan, m_prodi, m_fakultas
        $instansi = $db->table('t_instansi_mahasiswa')
            ->select('
                t_instansi_mahasiswa.*,
                m_instansi_pendidikan.instansi_pendidikan as nama_instansi,
                m_prodi.prodi,
                m_fakultas.fakultas
            ')
            ->join('m_instansi_pendidikan', 'm_instansi_pendidikan.id_instansi_pendidikan = t_instansi_mahasiswa.id_instansi_pendidikan', 'left')
            ->join('m_prodi', 'm_prodi.id_prodi = t_instansi_mahasiswa.id_prodi', 'left')
            ->join('m_fakultas', 'm_fakultas.id_fakultas = m_prodi.id_fakultas', 'left')
            ->where('t_instansi_mahasiswa.id_mahasiswa', $id_mahasiswa)
            ->get()->getRowArray();

        $data = [
            'title'            => 'Profil Mahasiswa',
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan'],
            'm'                => $mahasiswa,
            'i'                => $instansi
        ];

        return view('dashboard/mahasiswa/v_profil_mahasiswa', $data);
    }

    public function updateProfil()
    {
        $id_mahasiswa = session()->get('id_mahasiswa');
        if (!$id_mahasiswa) {
            return redirect()->to(base_url('login'));
        }

        $db = \Config\Database::connect();

        // 1. Data Pribadi & Domisili (Tabel m_mahasiswa)
        $dataMahasiswa = [
            'nik'           => $this->request->getPost('nik'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'tgl_lahir'     => $this->request->getPost('tgl_lahir'),
            'email'         => $this->request->getPost('email'),
            'no_telp'       => $this->request->getPost('no_telp'),
            'alamat'        => $this->request->getPost('alamat'),
            'rt'            => $this->request->getPost('rt'),
            'rw'            => $this->request->getPost('rw'),
            'kelurahan'     => $this->request->getPost('kelurahan'),
            'kecamatan'     => $this->request->getPost('kecamatan'),
            'provinsi'      => $this->request->getPost('provinsi')
        ];
        
        $db->table('m_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->update($dataMahasiswa);

        // 2. Data Akademik (Tabel t_instansi_mahasiswa)
        $instansi = $db->table('t_instansi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->get()->getRow();
        
        $dataAkademik = [
            'jenjang_pendidikan' => $this->request->getPost('jenjang_pendidikan'),
            'angkatan_tahun'     => $this->request->getPost('angkatan_tahun'),
            'semester'           => $this->request->getPost('semester'),
            'tahun_akademik'     => $this->request->getPost('tahun_akademik'),
        ];

        if ($instansi) {
            $db->table('t_instansi_mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->update($dataAkademik);
        } else {
            $dataAkademik['id_mahasiswa'] = $id_mahasiswa;
            $db->table('t_instansi_mahasiswa')->insert($dataAkademik);
        }

        session()->setFlashdata('sweet_success', 'Profil Anda berhasil diperbarui!');
        return redirect()->to(base_url('mahasiswa/profil'));
    }
}
