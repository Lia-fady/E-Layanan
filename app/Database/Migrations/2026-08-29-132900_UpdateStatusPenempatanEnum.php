<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Migration: Menambahkan status DISETUJUI dan DITOLAK ke ENUM status_penempatan
 * pada tabel t_penempatan_magang untuk mendukung alur status baru:
 * MENUNGGU → DISETUJUI → BERJALAN → SELESAI
 *                     ↘ DITOLAK (dikembalikan ke Sekretariat)
 *            DISETUJUI/BERJALAN → DIBATALKAN (mahasiswa mundur)
 */
class UpdateStatusPenempatanEnum extends Migration
{
    public function up()
    {
        // Ubah ENUM untuk menambahkan DISETUJUI dan DITOLAK
        $this->db->query("ALTER TABLE t_penempatan_magang MODIFY COLUMN status_penempatan ENUM('MENUNGGU','DISETUJUI','BERJALAN','SELESAI','DITOLAK','DIBATALKAN') DEFAULT 'MENUNGGU'");
        
        // Update data yang sudah ada: status BERJALAN yang tanggal_mulai belum tiba → DISETUJUI
        // (Hanya jika ada data lama yang perlu dikoreksi)
        $today = date('Y-m-d');
        $this->db->query("UPDATE t_penempatan_magang SET status_penempatan = 'DISETUJUI' WHERE status_penempatan = 'BERJALAN' AND tanggal_mulai > '{$today}'");
    }

    public function down()
    {
        // Kembalikan DISETUJUI → BERJALAN dan DITOLAK → DIBATALKAN sebelum revert ENUM
        $this->db->query("UPDATE t_penempatan_magang SET status_penempatan = 'BERJALAN' WHERE status_penempatan = 'DISETUJUI'");
        $this->db->query("UPDATE t_penempatan_magang SET status_penempatan = 'DIBATALKAN' WHERE status_penempatan = 'DITOLAK'");
        $this->db->query("ALTER TABLE t_penempatan_magang MODIFY COLUMN status_penempatan ENUM('MENUNGGU','BERJALAN','SELESAI','DIBATALKAN') DEFAULT 'MENUNGGU'");
    }
}
