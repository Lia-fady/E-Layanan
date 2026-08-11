<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Wilayah
        // Provinsi Banten
        $this->db->table('m_provinsi')->insert([
            'kode_provinsi' => '36',
            'nama_provinsi' => 'BANTEN',
            'created_at'    => date('Y-m-d H:i:s'),
        ]);
        $id_prov = $this->db->insertID();

        // Kabupaten/Kota
        $this->db->table('m_kabupaten')->insert([
            'id_provinsi'    => $id_prov,
            'kode_kabupaten' => '3671',
            'nama_kabupaten' => 'KOTA TANGERANG',
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
        $id_kab = $this->db->insertID();

        // Kecamatan
        $this->db->table('m_kecamatan')->insert([
            'id_kabupaten'   => $id_kab,
            'kode_kecamatan' => '367101',
            'nama_kecamatan' => 'TANGERANG',
            'created_at'     => date('Y-m-d H:i:s'),
        ]);
        $id_kec = $this->db->insertID();

        // Kelurahan
        $kelurahan_data = [
            [
                'id_kecamatan'   => $id_kec,
                'kode_kelurahan' => '3671011001',
                'nama_kelurahan' => 'SUKAASIH',
                'kode_pos'       => '15111',
                'created_at'     => date('Y-m-d H:i:s'),
            ],
            [
                'id_kecamatan'   => $id_kec,
                'kode_kelurahan' => '3671011002',
                'nama_kelurahan' => 'SUKASARI',
                'kode_pos'       => '15118',
                'created_at'     => date('Y-m-d H:i:s'),
            ],
        ];
        $this->db->table('m_kelurahan')->insertBatch($kelurahan_data);

        // 2. Jenjang Pendidikan
        $jenjang = [
            ['nama_jenjang' => 'SMA/SMK', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_jenjang' => 'D3', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_jenjang' => 'D4', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_jenjang' => 'S1', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
            ['nama_jenjang' => 'S2', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('m_jenjang_pendidikan')->insertBatch($jenjang);
        
        // Cari ID S1 dan SMK
        $id_s1 = $this->db->table('m_jenjang_pendidikan')->where('nama_jenjang', 'S1')->get()->getRow()->id_jenjang_pendidikan;
        $id_smk = $this->db->table('m_jenjang_pendidikan')->where('nama_jenjang', 'SMA/SMK')->get()->getRow()->id_jenjang_pendidikan;

        // 3. Instansi Pendidikan
        $this->db->table('m_instansi_pendidikan')->insert([
            'id_jenjang_pendidikan' => $id_s1,
            'instansi_pendidikan'   => 'Universitas Indonesia',
            'jenis_instansi'        => 'NEGERI',
            'status'                => 'AKTIF',
            'created_at'            => date('Y-m-d H:i:s'),
        ]);
        $id_ui = $this->db->insertID();

        $this->db->table('m_instansi_pendidikan')->insert([
            'id_jenjang_pendidikan' => $id_smk,
            'instansi_pendidikan'   => 'SMKN 1 Tangerang',
            'jenis_instansi'        => 'NEGERI',
            'status'                => 'AKTIF',
            'created_at'            => date('Y-m-d H:i:s'),
        ]);

        // 4. Fakultas
        $this->db->table('m_fakultas')->insert([
            'id_instansi_pendidikan' => $id_ui,
            'fakultas'               => 'Ilmu Komputer',
            'status'                 => 'AKTIF',
            'created_at'             => date('Y-m-d H:i:s'),
        ]);
        $id_fik = $this->db->insertID();

        $this->db->table('m_fakultas')->insert([
            'id_instansi_pendidikan' => $id_ui,
            'fakultas'               => 'Teknik',
            'status'                 => 'AKTIF',
            'created_at'             => date('Y-m-d H:i:s'),
        ]);
        $id_ft = $this->db->insertID();

        // 5. Prodi
        $prodi = [
            ['id_fakultas' => $id_fik, 'nama_prodi' => 'Teknik Informatika', 'jenjang' => 'S1', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
            ['id_fakultas' => $id_fik, 'nama_prodi' => 'Sistem Informasi', 'jenjang' => 'S1', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
            ['id_fakultas' => $id_ft, 'nama_prodi' => 'Teknik Sipil', 'jenjang' => 'S1', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
            ['id_fakultas' => $id_ft, 'nama_prodi' => 'Teknik Mesin', 'jenjang' => 'S1', 'status' => 'AKTIF', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('m_prodi')->insertBatch($prodi);
    }
}
