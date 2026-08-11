<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class FixProdi extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'fix:prodi';
    protected $description = 'Make id_prodi nullable.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        try {
            $db->query("ALTER TABLE `t_instansi_mahasiswa` MODIFY COLUMN `id_prodi` INT(11) UNSIGNED NULL DEFAULT NULL;");
            CLI::write("Column id_prodi is now nullable.", "green");
        } catch (\Exception $e) {
            CLI::write("Error: " . $e->getMessage(), "red");
        }
    }
}
