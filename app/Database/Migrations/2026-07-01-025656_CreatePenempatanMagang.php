<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenempatanMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_penempatan_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_bidang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_persetujuan_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_penempatan' => [
                'type'       => 'ENUM',
                'constraint' => ['BERJALAN', 'SELESAI', 'DIBATALKAN'],
                'default'    => 'BERJALAN',
            ],
            'is_log_book' => [
                'type'       => 'ENUM',
                'constraint' => ['ya', 'tidak'],
                'default'    => 'ya',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ]);

        // Mengatur id_penempatan_magang sebagai Primary Key
        $this->forge->addKey('id_penempatan_magang', true);

        // Membuat Foreign Key ke tabel m_bidang
        $this->forge->addForeignKey('id_bidang', 'm_bidang', 'id_bidang', 'CASCADE', 'CASCADE');

        // Membuat Foreign Key ke tabel t_persetujuan_magang
        $this->forge->addForeignKey('id_persetujuan_magang', 't_persetujuan_magang', 'id_persetujuan_magang', 'CASCADE', 'CASCADE');

        // Membuat Foreign Key ke tabel M_Mahasiswa_Mahasiswa
        $this->forge->addForeignKey('id_mahasiswa', 'M_Mahasiswa_Mahasiswa', 'id_mahasiswa', 'CASCADE', 'CASCADE');
        
        // Membuat tabel t_penempatan_magang
        $this->forge->createTable('t_penempatan_magang');
    }

    public function down()
    {
        $this->forge->dropTable('t_penempatan_magang');
    }
}