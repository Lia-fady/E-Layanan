<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserPegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user_pegawai' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'nip' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255', // Diseting 255 agar muat menampung hash password aman di CI4
            ],
            'kode_unor' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'id_bidang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'status_aktif' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'file_tanda_tangan' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'last_login' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_user_pegawai sebagai Primary Key
        $this->forge->addKey('id_user_pegawai', true);

        // Membuat Foreign Key ke tabel m_bidang
        $this->forge->addForeignKey('id_bidang', 'm_bidang', 'id_bidang', 'CASCADE', 'CASCADE');
        
        // Membuat tabel c_user_pegawai
        $this->forge->createTable('c_user_pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('c_user_pegawai');
    }
}