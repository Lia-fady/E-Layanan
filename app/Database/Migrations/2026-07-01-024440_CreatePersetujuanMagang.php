<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersetujuanMagang extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_persetujuan_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_permohonan_magang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status_persetujuan' => [
                'type'       => 'ENUM',
                'constraint' => ['MENUNGGU', 'DISETUJUI', 'DITOLAK'],
                'default'    => 'MENUNGGU',
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'created_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_by' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'disposisi' => [
                'type'       => 'ENUM',
                'constraint' => ['0', '1', '2'],
                'default'    => '0',
            ],
            'id_bidang' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'null'           => true,
            ],
            'tgl_persetujuan' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id_persetujuan_magang', true);
        $this->forge->addForeignKey('id_permohonan_magang', 't_permohonan_magang', 'id_permohonan_magang', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_bidang', 'm_bidang', 'id_bidang', 'CASCADE', 'SET NULL');
        
        $this->forge->createTable('t_persetujuan_magang');
    }

    public function down()
    {
        $this->forge->dropTable('t_persetujuan_magang');
    }
}