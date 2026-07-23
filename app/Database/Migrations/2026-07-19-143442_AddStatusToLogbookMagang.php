<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToLogbookMagang extends Migration
{
    public function up()
    {
        $fields = [
            'status_logbook' => [
                'type'       => 'ENUM',
                'constraint' => ['menunggu', 'disetujui', 'ditolak'],
                'default'    => 'menunggu',
                'after'      => 'tgl_logbook'
            ],
            'catatan_revisi' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status_logbook'
            ],
        ];
        $this->forge->addColumn('t_logbook_magang', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('t_logbook_magang', 'status_logbook');
        $this->forge->dropColumn('t_logbook_magang', 'catatan_revisi');
    }
}
