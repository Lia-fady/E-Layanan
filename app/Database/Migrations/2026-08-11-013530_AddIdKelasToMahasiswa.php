<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdKelasToMahasiswa extends Migration
{
    public function up()
    {
        $this->forge->addColumn('m_mahasiswa', [
            'id_kelas' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'semester'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('m_mahasiswa', 'id_kelas');
    }
}
