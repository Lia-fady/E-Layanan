<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterLogbookDatetimeColumns extends Migration
{
    public function up()
    {
        $fields = [
            'tgl_logbook' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'tgl_disetujui' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ];

        $this->forge->modifyColumn('t_logbook_magang', $fields);
    }

    public function down()
    {
        $fields = [
            'tgl_logbook' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'tgl_disetujui' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ];

        $this->forge->modifyColumn('t_logbook_magang', $fields);
    }
}
