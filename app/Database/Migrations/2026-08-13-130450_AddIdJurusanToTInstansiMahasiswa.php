<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdJurusanToTInstansiMahasiswa extends Migration
{
    public function up()
    {
        $fields = [
            'id_jurusan' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id_fakultas',
            ],
        ];
        $this->forge->addColumn('t_instansi_mahasiswa', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('t_instansi_mahasiswa', 'id_jurusan');
    }
}
