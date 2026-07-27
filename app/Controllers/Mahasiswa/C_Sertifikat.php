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

        $file_penerimaan = null;
        $file_selesai    = null;
        $file_piagam     = null;
        
        if (!empty($stateData['permohonan_aktif']['id_persetujuan_magang'])) {
            $db = \Config\Database::connect();
            $files = $db->table('t_file_proses_magang')
                        ->where('id_persetujuan_magang', $stateData['permohonan_aktif']['id_persetujuan_magang'])
                        ->get()->getResultArray();
            foreach ($files as $f) {
                if ($f['id_file'] == 8) $file_penerimaan = $f;
                if ($f['id_file'] == 9) $file_selesai = $f;
                if ($f['id_file'] == 10) $file_piagam = $f;
            }
        }

        $data = [
            'title'            => 'Dokumen Kegiatan',
            'nama'             => session()->get('nama_mahasiswa') ?? 'Mahasiswa', 
            'penempatan'       => $penempatan,
            'state'            => $stateData['state'],
            'is_log_book'      => $stateData['is_log_book'],
            'jenis_permohonan' => $stateData['jenis_permohonan'],
            'file_penerimaan'  => $file_penerimaan,
            'file_selesai'     => $file_selesai,
            'file_piagam'      => $file_piagam
        ];

        return view('mahasiswa/v_unduh_sertifikat', $data);
    }
}
