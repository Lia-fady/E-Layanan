<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterFileProsesMagang extends Migration
{
    public function up()
    {
        $fields = [
            'jenis_dokumen' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'id_persetujuan_magang'
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'path_file'
            ]
        ];
        $this->forge->addColumn('t_file_proses_magang', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('t_file_proses_magang', 'jenis_dokumen');
        $this->forge->dropColumn('t_file_proses_magang', 'catatan');
    }
}
