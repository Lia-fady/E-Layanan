<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProdi extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_prodi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_fakultas' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true, // Wajib unsigned agar tipe datanya sama persis dengan id_fakultas di tabel m_fakultas
            ],
            'prodi' => [
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

        // Mengatur id_prodi sebagai Primary Key
        $this->forge->addKey('id_prodi', true);

        // Membuat Foreign Key: Menghubungkan id_fakultas ke tabel m_fakultas
        $this->forge->addForeignKey('id_fakultas', 'm_fakultas', 'id_fakultas', 'CASCADE', 'CASCADE');
        
        // Membuat tabel m_prodi
        $this->forge->createTable('m_prodi');
    }

    public function down()
    {
        // Bagian ini otomatis akan menghapus foreign key terlebih dahulu sebelum drop tabel
        $this->forge->dropTable('m_prodi');
    }
}