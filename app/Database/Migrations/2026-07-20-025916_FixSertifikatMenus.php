<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixSertifikatMenus extends Migration
{
    public function up()
    {
        $db = \Config\Database::connect();
        
        // 1. Cari dan hapus menu lama "Sertifikat Magang" untuk Sekretariat (jika ada)
        $oldMenu = $db->table('c_menus')->where('url', 'sekretariat/sertifikat')->get()->getRow();
        if ($oldMenu) {
            $db->table('c_menus_privileges')->where('id_menu', $oldMenu->id)->delete();
            $db->table('c_menus')->where('id', $oldMenu->id)->delete();
        }

        // 2. Tambah menu baru "Sertifikat & Dokumen Akhir" untuk Kabid (Parent: Laporan Mahasiswa id=13)
        // Cek dulu biar nggak dobel
        $newMenuCek = $db->table('c_menus')->where('url', 'kabid/sertifikat')->get()->getRow();
        if (!$newMenuCek) {
            $db->table('c_menus')->insert([
                'name'      => 'Sertifikat & Dokumen',
                'url'       => 'kabid/sertifikat',
                'icon'      => 'bi bi-award-fill',
                'position'  => 3, // Di bawah Verifikasi Logbook
                'status'    => 1,
                'id_parent' => 13 // Laporan Mahasiswa
            ]);
            $newMenuId = $db->insertID();

            // Beri akses ke Kabid (id_user_group = 3)
            $db->table('c_menus_privileges')->insert([
                'id_user_group' => 3,
                'id_menu'       => $newMenuId
            ]);
        }
    }

    public function down()
    {
        $db = \Config\Database::connect();
        $newMenu = $db->table('c_menus')->where('url', 'kabid/sertifikat')->get()->getRow();
        if ($newMenu) {
            $db->table('c_menus_privileges')->where('id_menu', $newMenu->id)->delete();
            $db->table('c_menus')->where('id', $newMenu->id)->delete();
        }
    }
}
