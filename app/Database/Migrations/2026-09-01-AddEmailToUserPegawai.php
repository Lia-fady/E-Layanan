<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToUserPegawai extends Migration
{
    public function up()
    {
        $fields = [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
                'after'      => 'nip',
            ],
        ];
        $this->forge->addColumn('c_user_pegawai', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('c_user_pegawai', 'email');
    }
}
?>
