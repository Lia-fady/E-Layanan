<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateFileSelesaiToProses extends Migration
{
    public function up()
    {
        // 1. Rename column id_penempatan_magang to id_persetujuan_magang
        $this->forge->modifyColumn('t_file_selesai_magang', [
            'id_penempatan_magang' => [
                'name'       => 'id_persetujuan_magang',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ]
        ]);

        // 2. Add proses_magang column
        $this->forge->addColumn('t_file_selesai_magang', [
            'proses_magang' => [
                'type'       => 'ENUM',
                'constraint' => ['persetujuan', 'selesai'],
                'default'    => 'persetujuan',
                'after'      => 'updated_by'
            ]
        ]);

        // 3. Rename table
        $this->forge->renameTable('t_file_selesai_magang', 't_file_proses_magang');
    }

    public function down()
    {
        // Rollback: rename table back
        $this->forge->renameTable('t_file_proses_magang', 't_file_selesai_magang');

        // Rollback: drop proses_magang column
        $this->forge->dropColumn('t_file_selesai_magang', 'proses_magang');

        // Rollback: rename id_persetujuan_magang to id_penempatan_magang
        $this->forge->modifyColumn('t_file_selesai_magang', [
            'id_persetujuan_magang' => [
                'name'       => 'id_penempatan_magang',
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ]
        ]);
    }
}
