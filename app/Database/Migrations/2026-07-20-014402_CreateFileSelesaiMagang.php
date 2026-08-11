<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFileSelesaiMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_file_proses_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penempatan_magang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_file' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id_file_proses_magang', true);
        
        $this->forge->addForeignKey('id_penempatan_magang', 't_penempatan_magang', 'id_penempatan_magang', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_file', 'm_file', 'id_file', 'CASCADE', 'CASCADE');

        $this->forge->createTable('t_file_selesai_magang');
    }

    public function down()
    {
        $this->forge->dropTable('t_file_selesai_magang');
    }
}

