<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogbookMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_logbook_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penempatan_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'logbook_magang' => [
                'type' => 'TEXT',
            ],
            'tgl_logbook' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'disetujui_oleh' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true, // Di-null-kan dulu sebelum disetujui oleh Pegawai/Pembimbing
            ],
            'file_tanda_tangan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'tgl_disetujui' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        // Mengatur id_logbook_magang sebagai Primary Key
        $this->forge->addKey('id_logbook_magang', true);

        // Membuat Foreign Key ke tabel t_penempatan_magang
        $this->forge->addForeignKey('id_penempatan_magang', 't_penempatan_magang', 'id_penempatan_magang', 'CASCADE', 'CASCADE');

        // Membuat Foreign Key ke tabel c_user_pegawai (kolom disetujui_oleh merujuk ke id_user_pegawai)
        $this->forge->addForeignKey('disetujui_oleh', 'c_user_pegawai', 'id_user_pegawai', 'CASCADE', 'SET NULL');
        
        // Membuat tabel t_logbook_magang
        $this->forge->createTable('t_logbook_magang');
    }

    public function down()
    {
        $this->forge->dropTable('t_logbook_magang');
    }
}