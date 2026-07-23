<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateJenisPermohonan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_jenis_permohonan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jenis_permohonan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
        ]);

        // Mengatur id_jenis_permohonan sebagai Primary Key (PK)
        $this->forge->addKey('id_jenis_permohonan', true);
        
        // Membuat tabel dengan nama m_jenis_permohonan
        $this->forge->createTable('m_jenis_permohonan');
    }

    public function down()
    {
        $this->forge->dropTable('m_jenis_permohonan');
    }
}