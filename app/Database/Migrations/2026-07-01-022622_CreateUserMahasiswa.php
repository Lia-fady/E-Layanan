<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserMahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255', // Diseting 255 agar muat menampung hash password aman (password_hash) di CI4
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_user_mahasiswa sebagai Primary Key
        $this->forge->addKey('id_user_mahasiswa', true);

        // Membuat Foreign Key ke tabel M_Mahasiswa_Mahasiswa
        $this->forge->addForeignKey('id_mahasiswa', 'M_Mahasiswa_Mahasiswa', 'id_mahasiswa', 'CASCADE', 'CASCADE');
        
        // Membuat tabel m_user_mahasiswa
        $this->forge->createTable('m_user_mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('m_user_mahasiswa');
    }
}