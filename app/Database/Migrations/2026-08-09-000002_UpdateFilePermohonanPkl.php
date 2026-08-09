<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateFilePermohonanPkl extends Migration
{
    public function up()
    {
        // 1. Rename ID 1 in m_file to 'Surat Pengantar'
        $this->db->query("UPDATE m_file SET nama_file_master = 'Surat Pengantar' WHERE id_file_master = 1");

        // 2. Insert 'Kartu Pelajar' (id 12) if not exists
        $this->db->query("INSERT IGNORE INTO m_file (id_file_master, nama_file_master, path_file_master, ekstensi, isActive) VALUES (12, 'Kartu Pelajar', '', 'pdf', 1)");

        // 3. Clear existing mappings for PKL
        $this->db->query("DELETE FROM m_file_permohonan WHERE id_jenis_permohonan = 5");

        // 4. Insert correct mappings for PKL (Surat Pengantar, CV, Kartu Pelajar)
        $this->db->query("INSERT INTO m_file_permohonan (id_jenis_permohonan, id_file, urutan, wajib) VALUES 
            (5, 1, 1, 'YA'),
            (5, 3, 2, 'YA'),
            (5, 12, 3, 'YA')
        ");
    }

    public function down()
    {
        $this->db->query("DELETE FROM m_file_permohonan WHERE id_jenis_permohonan = 5");
        $this->db->query("INSERT INTO m_file_permohonan (id_jenis_permohonan, id_file, urutan, wajib) VALUES 
            (5, 1, 1, 'YA'),
            (5, 11, 2, 'YA')
        ");
    }
}
