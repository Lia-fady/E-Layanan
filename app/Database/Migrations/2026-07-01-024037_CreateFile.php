<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFile extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_file' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_file' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
        ]);

        // Mengatur id_file sebagai Primary Key
        $this->forge->addKey('id_file', true);

        // Membuat tabel m_file
        $this->forge->createTable('m_file');
    }

    public function down()
    {
        $this->forge->dropTable('m_file');
    }
}