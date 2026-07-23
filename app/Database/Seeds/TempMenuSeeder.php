<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TempMenuSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Hapus menu lama Kabid agar tidak duplikat
        $kabid_menus = $db->table('c_menus_privileges')->where('id_user_group', 3)->get()->getResultArray();
        $menu_ids = array_column($kabid_menus, 'id_menu');

        if (!empty($menu_ids)) {
            $db->table('c_menus_privileges')->where('id_user_group', 3)->delete();
        }

        $menus = [
            [
                'id_parent' => null, 'name' => 'Menu Utama', 'url' => 'header', 
                'position' => 10, 'icon' => '', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Dashboard', 'url' => 'kabid/dashboard', 
                'position' => 11, 'icon' => 'bi bi-grid-1x2', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Proses Penempatan', 'url' => 'header', 
                'position' => 12, 'icon' => '', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Disposisi Masuk', 'url' => 'kabid/penempatan', 
                'position' => 13, 'icon' => 'bi bi-person-lines-fill', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Pantauan Aktif', 'url' => 'header', 
                'position' => 14, 'icon' => '', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Mahasiswa Aktif', 'url' => 'kabid/riwayat', 
                'position' => 15, 'icon' => 'bi bi-people', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Informasi Kuota', 'url' => 'kabid/kuota', 
                'position' => 16, 'icon' => 'bi bi-pie-chart', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Verifikasi Logbook', 'url' => 'kabid/verifikasi-logbook', 
                'position' => 17, 'icon' => 'bi bi-journal-check', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Dokumen & Kelulusan', 'url' => 'header', 
                'position' => 18, 'icon' => '', 'status' => 1
            ],
            [
                'id_parent' => null, 'name' => 'Manajemen Dokumen', 'url' => 'kabid/sertifikat', 
                'position' => 19, 'icon' => 'bi bi-award', 'status' => 1
            ]
        ];

        $parent_menu_utama = null;
        $parent_penempatan = null;
        $parent_pantauan = null;
        $parent_dokumen = null;

        foreach ($menus as $m) {
            $db->table('c_menus')->insert($m);
            $new_id = $db->insertID();
            
            if ($m['name'] == 'Menu Utama') $parent_menu_utama = $new_id;
            if ($m['name'] == 'Proses Penempatan') $parent_penempatan = $new_id;
            if ($m['name'] == 'Pantauan Aktif') $parent_pantauan = $new_id;
            if ($m['name'] == 'Dokumen & Kelulusan') $parent_dokumen = $new_id;

            if ($m['name'] == 'Dashboard') {
                $db->table('c_menus')->where('id', $new_id)->update(['id_parent' => $parent_menu_utama]);
            }
            if ($m['name'] == 'Disposisi Masuk') {
                $db->table('c_menus')->where('id', $new_id)->update(['id_parent' => $parent_penempatan]);
            }
            if ($m['name'] == 'Mahasiswa Aktif' || $m['name'] == 'Verifikasi Logbook' || $m['name'] == 'Informasi Kuota') {
                $db->table('c_menus')->where('id', $new_id)->update(['id_parent' => $parent_pantauan]);
            }
            if ($m['name'] == 'Manajemen Dokumen') {
                $db->table('c_menus')->where('id', $new_id)->update(['id_parent' => $parent_dokumen]);
            }

            $db->table('c_menus_privileges')->insert([
                'id_user_group' => 3,
                'id_menu' => $new_id
            ]);
        }

        $db->query("DELETE FROM c_menus WHERE id IN (SELECT id_menu FROM c_menus_privileges WHERE id_user_group = 3) AND position < 10");
        $db->query("DELETE FROM c_menus_privileges WHERE id_menu NOT IN (SELECT id FROM c_menus)");

        echo "Menu Kabid updated.\n";
    }
}
