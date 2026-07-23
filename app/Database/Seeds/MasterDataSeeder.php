<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Data m_jenis_permohonan
        $dataJenisPermohonan = [
            ['id_jenis_permohonan' => 1, 'jenis_permohonan' => 'Penelitian Skripsi / TA'],
            ['id_jenis_permohonan' => 2, 'jenis_permohonan' => 'Observasi / Pengambilan Data'],
            ['id_jenis_permohonan' => 3, 'jenis_permohonan' => 'Magang / PKL'],
            ['id_jenis_permohonan' => 4, 'jenis_permohonan' => 'Uji Coba Produk (Prototype)'],
        ];
        $this->db->table('m_jenis_permohonan')->ignore(true)->insertBatch($dataJenisPermohonan);

        // 2. Data m_file
        $dataFile = [
            ['id_file' => 1, 'nama_file' => 'Surat Pengantar Resmi Kampus', 'status_aktif' => '1'],
            ['id_file' => 2, 'nama_file' => 'Surat Pengantar Resmi Kampus', 'status_aktif' => '1'],
            ['id_file' => 3, 'nama_file' => 'Curriculum Vitae (CV)', 'status_aktif' => '1'],
            ['id_file' => 4, 'nama_file' => 'Proposal / Sinopsis', 'status_aktif' => '1'],
            ['id_file' => 5, 'nama_file' => 'Surat Pengantar Resmi Kampus', 'status_aktif' => '1'],
            ['id_file' => 6, 'nama_file' => 'Surat Pengantar Resmi Kampus', 'status_aktif' => '1'],
            ['id_file' => 7, 'nama_file' => 'Proposal Uji Coba Produk', 'status_aktif' => '1'],
        ];
        $this->db->table('m_file')->ignore(true)->insertBatch($dataFile);

        // 3. Data Pivot m_file_permohonan (Relasi Jenis Permohonan <-> File)
        $dataPivot = [
            // Penelitian (1) -> Surat(1), Proposal(4)
            ['id_jenis_permohonan' => 1, 'id_file' => 1],
            ['id_jenis_permohonan' => 1, 'id_file' => 4],
            // Observasi (2) -> Surat(5) saja
            ['id_jenis_permohonan' => 2, 'id_file' => 5],
            // Magang (3) -> Surat(2), CV(3)
            ['id_jenis_permohonan' => 3, 'id_file' => 2],
            ['id_jenis_permohonan' => 3, 'id_file' => 3],
            // Uji Coba (4) -> Surat(6), Proposal(7)
            ['id_jenis_permohonan' => 4, 'id_file' => 6],
            ['id_jenis_permohonan' => 4, 'id_file' => 7],
        ];
        $this->db->table('m_file_permohonan')->ignore(true)->insertBatch($dataPivot);

        // 4. Data m_bidang (Untuk Penempatan Kabid)
        $dataBidang = [
            ['id_bidang' => 1, 'bidang' => 'Sekretariat', 'status_aktif' => 1],
            ['id_bidang' => 2, 'bidang' => 'Bidang Diseminasi Informasi Dan Komunikasi Publik', 'status_aktif' => 1],
            ['id_bidang' => 3, 'bidang' => 'Bidang Sarana, Prasarana TIK dan Persandian', 'status_aktif' => 1],
            ['id_bidang' => 4, 'bidang' => 'Bidang Statistik Dan Pemberdayaan TIK', 'status_aktif' => 1],
            ['id_bidang' => 5, 'bidang' => 'Bidang Pengembangan E-Goverment', 'status_aktif' => 1],
        ];
        $this->db->table('m_bidang')->ignore(true)->insertBatch($dataBidang);

        // 5. Data m_instansi_pendidikan
        $dataInstansi = [
            ['id_instansi_pendidikan' => 1, 'instansi_pendidikan' => 'Universitas Indonesia', 'jenis_instansi' => 'negeri', 'status' => 'aktif'],
            ['id_instansi_pendidikan' => 2, 'instansi_pendidikan' => 'Universitas Gadjah Mada', 'jenis_instansi' => 'negeri', 'status' => 'aktif'],
            ['id_instansi_pendidikan' => 3, 'instansi_pendidikan' => 'Universitas Brawijaya', 'jenis_instansi' => 'negeri', 'status' => 'aktif'],
            ['id_instansi_pendidikan' => 4, 'instansi_pendidikan' => 'Universitas Gunadarma', 'jenis_instansi' => 'swasta', 'status' => 'aktif'],
            ['id_instansi_pendidikan' => 5, 'instansi_pendidikan' => 'Bina Nusantara (Binus)', 'jenis_instansi' => 'swasta', 'status' => 'aktif'],
            ['id_instansi_pendidikan' => 6, 'instansi_pendidikan' => 'Universitas Muhammadiyah Tangerang', 'jenis_instansi' => 'swasta', 'status' => 'aktif'],
        ];
        $this->db->table('m_instansi_pendidikan')->ignore(true)->insertBatch($dataInstansi);

        // 6. Data m_fakultas
        $dataFakultas = [
            ['id_fakultas' => 1, 'fakultas' => 'Fakultas Ilmu Komputer', 'status' => 'aktif'],
            ['id_fakultas' => 2, 'fakultas' => 'Fakultas Teknik', 'status' => 'aktif'],
            ['id_fakultas' => 3, 'fakultas' => 'Fakultas Ekonomi dan Bisnis', 'status' => 'aktif'],
            ['id_fakultas' => 4, 'fakultas' => 'Fakultas Ilmu Sosial dan Ilmu Politik', 'status' => 'aktif'],
        ];
        $this->db->table('m_fakultas')->ignore(true)->insertBatch($dataFakultas);

        // 7. Data m_prodi
        $dataProdi = [
            ['id_prodi' => 1, 'id_fakultas' => 1, 'prodi' => 'Teknik Informatika', 'status' => 'aktif'],
            ['id_prodi' => 2, 'id_fakultas' => 1, 'prodi' => 'Sistem Informasi', 'status' => 'aktif'],
            ['id_prodi' => 3, 'id_fakultas' => 2, 'prodi' => 'Teknik Elektro', 'status' => 'aktif'],
            ['id_prodi' => 4, 'id_fakultas' => 2, 'prodi' => 'Teknik Industri', 'status' => 'aktif'],
            ['id_prodi' => 5, 'id_fakultas' => 3, 'prodi' => 'Manajemen Bisnis', 'status' => 'aktif'],
            ['id_prodi' => 6, 'id_fakultas' => 4, 'prodi' => 'Ilmu Komunikasi', 'status' => 'aktif'],
        ];
        $this->db->table('m_prodi')->ignore(true)->insertBatch($dataProdi);

        // 8. Data Akun Pegawai (Untuk testing login Sekretariat & Kabid)
        $passwordDefault = password_hash('password123', PASSWORD_DEFAULT);
        $dataPegawai = [
            [
                'id_user_pegawai' => 1, 
                'nama'            => 'Admin Sekretariat', 
                'nip'             => '12345678', 
                'password'        => $passwordDefault, 
                'id_bidang'       => null, 
                'id_user_group'   => 2,
                'kode_unor'       => 'SEKRETARIAT',
                'status_aktif'    => '1',
            ],
            [
                'id_user_pegawai' => 2, 
                'nama'            => 'Kepala Bidang Diseminasi Informasi', 
                'nip'             => '87654321', 
                'password'        => $passwordDefault, 
                'id_bidang'       => 2, 
                'id_user_group'   => 3,
                'kode_unor'       => 'KABID',
                'status_aktif'    => '1',
            ],
            [
                'id_user_pegawai' => 3, 
                'nama'            => 'Kepala Bidang Sarana & Prasarana TIK', 
                'nip'             => '87654322', 
                'password'        => $passwordDefault, 
                'id_bidang'       => 3, 
                'id_user_group'   => 3,
                'kode_unor'       => 'KABID',
                'status_aktif'    => '1',
            ],
            [
                'id_user_pegawai' => 4, 
                'nama'            => 'Kepala Bidang Statistik', 
                'nip'             => '87654323', 
                'password'        => $passwordDefault, 
                'id_bidang'       => 4, 
                'id_user_group'   => 3,
                'kode_unor'       => 'KABID',
                'status_aktif'    => '1',
            ],
            [
                'id_user_pegawai' => 5, 
                'nama'            => 'Kepala Bidang Pengembangan E-Gov', 
                'nip'             => '87654324', 
                'password'        => $passwordDefault, 
                'id_bidang'       => 5, 
                'id_user_group'   => 3,
                'kode_unor'       => 'KABID',
                'status_aktif'    => '1',
            ],
        ];
        $this->db->table('c_user_pegawai')->ignore(true)->insertBatch($dataPegawai);
    }
}
