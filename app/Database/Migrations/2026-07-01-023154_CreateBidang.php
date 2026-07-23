<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBidang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_bidang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'bidang' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'id_opd' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
        ]);

        // Mengatur id_bidang sebagai Primary Key
        $this->forge->addKey('id_bidang', true);

        // Membuat Foreign Key ke tabel m_opd
        $this->forge->addForeignKey('id_opd', 'm_opd', 'id_opd', 'CASCADE', 'CASCADE');
        
        // Membuat tabel m_bidang
        $this->forge->createTable('m_bidang');
    }

    public function down()
    {
        $this->forge->dropTable('m_bidang');
    }
}