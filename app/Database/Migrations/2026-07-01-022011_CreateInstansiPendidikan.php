<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstansiPendidikan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_instansi_pendidikan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'instansi_pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'jenis_instansi' => [
                'type'       => 'ENUM',
                'constraint' => ['negeri', 'swasta'],
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_instansi_pendidikan sebagai Primary Key
        $this->forge->addKey('id_instansi_pendidikan', true);
        
        // Membuat tabel m_instansi_pendidikan
        $this->forge->createTable('m_instansi_pendidikan');
    }

    public function down()
    {
        $this->forge->dropTable('m_instansi_pendidikan');
    }
}