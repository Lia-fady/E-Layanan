<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKuota extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kuota' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_bidang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'kuota' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
        ]);

        // Mengatur id_kuota sebagai Primary Key
        $this->forge->addKey('id_kuota', true);

        // Membuat Foreign Key ke tabel m_bidang
        $this->forge->addForeignKey('id_bidang', 'm_bidang', 'id_bidang', 'CASCADE', 'CASCADE');
        
        // Membuat tabel m_kuota
        $this->forge->createTable('m_kuota');
    }

    public function down()
    {
        $this->forge->dropTable('m_kuota');
    }
}