<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFilePermohonan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_file_permohonan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_file' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_jenis_permohonan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ]
        ]);

        $this->forge->addKey('id_file_permohonan', true);
        $this->forge->addForeignKey('id_file', 'm_file', 'id_file', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_jenis_permohonan', 'm_jenis_permohonan', 'id_jenis_permohonan', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('m_file_permohonan');
    }

    public function down()
    {
        $this->forge->dropTable('m_file_permohonan');
    }
}
