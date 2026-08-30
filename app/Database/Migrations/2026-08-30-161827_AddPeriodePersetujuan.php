<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPeriodePersetujuan extends Migration
{
    public function up()
    {
        $fields = [
            'tgl_mulai_disetujui' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'tgl_persetujuan'
            ],
            'tgl_selesai_disetujui' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'tgl_mulai_disetujui'
            ],
            'status_persetujuan_mahasiswa' => [
                'type'       => 'ENUM',
                'constraint' => ['MENUNGGU', 'DISETUJUI', 'DITOLAK'],
                'default'    => 'MENUNGGU',
                'after'      => 'tgl_selesai_disetujui'
            ],
        ];

        $this->forge->addColumn('t_persetujuan_magang', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('t_persetujuan_magang', 'tgl_mulai_disetujui');
        $this->forge->dropColumn('t_persetujuan_magang', 'tgl_selesai_disetujui');
        $this->forge->dropColumn('t_persetujuan_magang', 'status_persetujuan_mahasiswa');
    }
}
