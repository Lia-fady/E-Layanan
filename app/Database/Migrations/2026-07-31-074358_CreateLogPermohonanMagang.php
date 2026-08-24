<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogPermohonanMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_log' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_permohonan_magang' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'aktor' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'aksi' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id_log', true);
        $this->forge->addForeignKey('id_permohonan_magang', 't_permohonan_magang', 'id_permohonan_magang', 'CASCADE', 'CASCADE');
        $this->forge->createTable('t_log_permohonan');
    }

    public function down()
    {
        $this->forge->dropTable('t_log_permohonan');
    }
}
