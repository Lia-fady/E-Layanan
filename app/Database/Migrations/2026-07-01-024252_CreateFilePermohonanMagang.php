<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFilePermohonanMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_file_permohonan_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_permohonan_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_file_permohonan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_file_permohonan_magang sebagai Primary Key
        $this->forge->addKey('id_file_permohonan_magang', true);

        // Membuat Foreign Key ke tabel t_permohonan_magang
        $this->forge->addForeignKey('id_permohonan_magang', 't_permohonan_magang', 'id_permohonan_magang', 'CASCADE', 'CASCADE');

        // Membuat Foreign Key ke tabel m_file_permohonan
        $this->forge->addForeignKey('id_file_permohonan', 'm_file_permohonan', 'id_file_permohonan', 'CASCADE', 'CASCADE');
        
        // Membuat tabel t_file_permohonan_magang
        $this->forge->createTable('t_file_permohonan_magang');
    }

    public function down()
    {
        $this->forge->dropTable('t_file_permohonan_magang');
    }
}