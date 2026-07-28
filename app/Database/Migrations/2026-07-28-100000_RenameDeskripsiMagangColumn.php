<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameDeskripsiMagangColumn extends Migration
{
    public function up()
    {
        $fields = [
            'deskripsi_magang' => [
                'name' => 'deskripsi',
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->modifyColumn('t_permohonan_magang', $fields);
    }

    public function down()
    {
        $fields = [
            'deskripsi' => [
                'name' => 'deskripsi_magang',
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->modifyColumn('t_permohonan_magang', $fields);
    }
}
