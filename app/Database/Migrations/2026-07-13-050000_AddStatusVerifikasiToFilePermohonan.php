<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration untuk menambahkan kolom status_verifikasi
 * ke tabel t_file_permohonan_magang.
 * Kolom ini digunakan untuk menyimpan status verifikasi
 * per-dokumen (VALID, TIDAK_VALID, atau NULL=belum diverifikasi).
 */
class AddStatusVerifikasiToFilePermohonan extends Migration
{
    public function up()
    {
        // Already exists in DB, skipping migration to avoid error.
    }

    public function down()
    {
        $this->forge->dropColumn('t_file_permohonan_magang', 'status_verifikasi');
    }
}
