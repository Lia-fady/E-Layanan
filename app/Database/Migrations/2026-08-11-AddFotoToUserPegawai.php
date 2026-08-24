<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFotoToUserPegawai extends Migration
{
    public function up()
    {
        $fields = [
            'foto' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'jabatan',
            ],
        ];
        $this->forge->addColumn('c_user_pegawai', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('c_user_pegawai', 'foto');
    }
}
?>
