<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFakultas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_fakultas' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'fakultas' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_fakultas sebagai Primary Key
        $this->forge->addKey('id_fakultas', true);
        
        // Membuat tabel m_fakultas
        $this->forge->createTable('m_fakultas');
    }

    public function down()
    {
        $this->forge->dropTable('m_fakultas');
    }
}