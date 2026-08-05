<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDurasiToJenisPermohonan extends Migration
{
    public function up()
    {
        $fields = [
            'durasi_permohonan' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'jenis_permohonan'
            ],
        ];
        $this->forge->addColumn('m_jenis_permohonan', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('m_jenis_permohonan', 'durasi_permohonan');
    }
}
