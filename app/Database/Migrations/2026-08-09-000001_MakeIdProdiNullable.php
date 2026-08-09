<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MakeIdProdiNullable extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('t_instansi_mahasiswa', [
            'id_prodi' => [
                'name'       => 'id_prodi',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->modifyColumn('t_instansi_mahasiswa', [
            'id_prodi' => [
                'name'       => 'id_prodi',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
        ]);
    }
}
