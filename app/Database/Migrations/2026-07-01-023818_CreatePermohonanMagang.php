<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePermohonanMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_permohonan_magang' => [
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
            'id_instansi_mahasiswa' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'id_jenis_permohonan' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'deskripsi_keahlian' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'deskripsi_magang' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'tgl_mulai' => [
                'type'       => 'DATE',
            ],
            'tgl_selesai' => [
                'type'       => 'DATE',
            ],
            'posting_data' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'kirim'],
                'default'    => 'draft',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        // Mengatur id_permohonan_magang sebagai Primary Key
        $this->forge->addKey('id_permohonan_magang', true);

        // Membuat Foreign Key ke tabel M_Mahasiswa_Mahasiswa
        $this->forge->addForeignKey('id_mahasiswa', 'M_Mahasiswa_Mahasiswa', 'id_mahasiswa', 'CASCADE', 'CASCADE');

        // Membuat Foreign Key ke tabel t_instansi_mahasiswa
        $this->forge->addForeignKey('id_instansi_mahasiswa', 't_instansi_mahasiswa', 'id_instansi_mahasiswa', 'CASCADE', 'CASCADE');

        // Membuat Foreign Key ke tabel m_jenis_permohonan
        $this->forge->addForeignKey('id_jenis_permohonan', 'm_jenis_permohonan', 'id_jenis_permohonan', 'CASCADE', 'CASCADE');
        
        // Membuat tabel t_permohonan_magang
        $this->forge->createTable('t_permohonan_magang');
    }

    public function down()
    {
        $this->forge->dropTable('t_permohonan_magang');
    }
}