<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckSchema extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'check:schema';
    protected $description = 'Check schema.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        $fields = $db->getFieldData('t_instansi_mahasiswa');
        foreach ($fields as $field) {
            CLI::write($field->name . " - Nullable: " . ($field->nullable ? "YES" : "NO") . " - Default: " . $field->default, "green");
        }
    }
}
