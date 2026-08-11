<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MasterKelasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama_kelas' => '10',
                'status'     => 'AKTIF',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kelas' => '11',
                'status'     => 'AKTIF',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kelas' => '12',
                'status'     => 'AKTIF',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nama_kelas' => 'Lainnya',
                'status'     => 'AKTIF',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        $this->db->table('m_kelas')->insertBatch($data);
    }
}
