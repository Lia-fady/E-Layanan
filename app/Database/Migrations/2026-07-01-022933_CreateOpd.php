<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOpd extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_opd' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'opd' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
        ]);

        // Mengatur id_opd sebagai Primary Key
        $this->forge->addKey('id_opd', true);
        
        // Membuat tabel m_opd
        $this->forge->createTable('m_opd');
    }

    public function down()
    {
        $this->forge->dropTable('m_opd');
    }
}