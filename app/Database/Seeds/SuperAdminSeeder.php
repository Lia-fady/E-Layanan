<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'nama'              => 'Super Admin',
            'nip'               => '00000001',
            'password'          => password_hash('superadmin123', PASSWORD_DEFAULT),
            'kode_unor'         => 'SUPERADMIN',
            'id_user_group'     => 1, // SuperAdmin
            'status_aktif'      => '1',
            'created_at'        => date('Y-m-d H:i:s'),
            'updated_at'        => date('Y-m-d H:i:s'),
        ];

        // Cek jika sudah ada
        $existing = $this->db->table('c_user_pegawai')->where('nip', '00000001')->get()->getRow();
        if (!$existing) {
            $this->db->table('c_user_pegawai')->insert($data);
            echo "SuperAdmin user seeded successfully. NIP: 00000001, Password: superadmin123\n";
        } else {
            echo "SuperAdmin user already exists.\n";
        }
    }
}
