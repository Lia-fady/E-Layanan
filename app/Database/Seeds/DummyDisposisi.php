<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DummyDisposisi extends Seeder
{
    public function run()
    {
        // 1. Pastikan ada data permohonan yang ada di database, ubah salah satu menjadi DISETUJUI
        $persetujuan = $this->db->table('t_persetujuan_magang')->limit(1)->get()->getRow();
        if ($persetujuan) {
            $this->db->table('t_persetujuan_magang')
                ->where('id_persetujuan_magang', $persetujuan->id_persetujuan_magang)
                ->update([
                    'status_persetujuan' => 'DISETUJUI',
                    'disposisi' => '0'
                ]);
            echo "Berhasil mengupdate permohonan ID: " . $persetujuan->id_permohonan_magang . " menjadi siap didisposisikan.\n";
        } else {
            echo "Belum ada data persetujuan sama sekali. Silakan ajukan permohonan terlebih dahulu melalui form.\n";
        }
    }
}
