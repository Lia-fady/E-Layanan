<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBuktiKegiatanToLogbookMagang extends Migration
{
    public function up()
    {
        // Already exists in DB
    }

    public function down()
    {
        $this->forge->dropColumn('t_logbook_magang', 'bukti_kegiatan');
    }
}
