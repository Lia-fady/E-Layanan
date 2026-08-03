<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInstansiMahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_instansi_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                // Catatan: FK id_mahasiswa ke M_Mahasiswa_Mahasiswa sengaja tidak diikat di sini dulu 
                // karena tabel M_Mahasiswa_Mahasiswa belum kita buat (menghindari error urutan migrasi).
            ],
            'id_instansi_pendidikan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_prodi' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'jenjang_pendidikan' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'angkatan_tahun' => [
                'type'       => 'VARCHAR',
                'constraint' => '4',
                'null'       => true,
            ],
            'semester' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
            ],
            'tahun_akademik' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_instansi_mahasiswa sebagai Primary Key
        $this->forge->addKey('id_instansi_mahasiswa', true);

        // Membuat Foreign Key ke tabel m_instansi_pendidikan
        $this->forge->addForeignKey('id_instansi_pendidikan', 'm_instansi_pendidikan', 'id_instansi_pendidikan', 'CASCADE', 'CASCADE');

        // Membuat Foreign Key ke tabel m_prodi
        $this->forge->addForeignKey('id_prodi', 'm_prodi', 'id_prodi', 'CASCADE', 'CASCADE');
        
        // Membuat tabel t_instansi_mahasiswa
        $this->forge->createTable('t_instansi_mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('t_instansi_mahasiswa');
    }
}