<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTglPenetapanTopenempatan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('t_penempatan_magang', [
            'tgl_penetapan_magang' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'is_log_book',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('t_penempatan_magang', 'tgl_penetapan_magang');
    }
}
