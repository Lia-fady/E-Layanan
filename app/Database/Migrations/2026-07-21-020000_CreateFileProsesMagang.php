<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFileProsesMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_file_selesai_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_persetujuan_magang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_file_permohonan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'path_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'proses_magang' => [
                'type'       => 'ENUM',
                'constraint' => ['persetujuan', 'selesai'],
                'default'    => 'persetujuan',
            ],
        ]);

        $this->forge->addKey('id_file_selesai_magang', true);
        $this->forge->addKey('id_persetujuan_magang');
        $this->forge->createTable('t_file_proses_magang', true);
    }

    public function down()
    {
        $this->forge->dropTable('t_file_proses_magang', true);
    }
}
