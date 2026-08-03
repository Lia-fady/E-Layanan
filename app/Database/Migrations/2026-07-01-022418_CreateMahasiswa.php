<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nik' => [
                'type'       => 'VARCHAR',
                'constraint' => '16',
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'nama_mahasiswa' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'jenis_kelamin' => [
                'type'       => 'ENUM',
                'constraint' => ['L', 'P'], // Laki-laki / Perempuan
            ],
            'tgl_lahir' => [
                'type' => 'DATE',
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'rt' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'null'       => true,
            ],
            'rw' => [
                'type'       => 'VARCHAR',
                'constraint' => '5',
                'null'       => true,
            ],
            'kelurahan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'kecamatan' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'provinsi' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'no_telp' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'id_instansi_mahasiswa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_mahasiswa sebagai Primary Key
        $this->forge->addKey('id_mahasiswa', true);

        // Membuat Foreign Key ke tabel t_instansi_mahasiswa
        $this->forge->addForeignKey('id_instansi_mahasiswa', 't_instansi_mahasiswa', 'id_instansi_mahasiswa', 'CASCADE', 'CASCADE');
        
        // Membuat tabel m_mahasiswa
        $this->forge->createTable('m_mahasiswa');
    }

    public function down()
    {
        $this->forge->dropTable('m_mahasiswa');
    }
}