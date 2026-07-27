<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AddStatusVerifikasi extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'db:add_status_verifikasi';
    protected $description = 'Add status_verifikasi column to t_file_permohonan_magang.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        try {
            $db->query("ALTER TABLE t_file_permohonan_magang ADD COLUMN status_verifikasi VARCHAR(20) NULL DEFAULT NULL AFTER path_file;");
            CLI::write('Column status_verifikasi added successfully!', 'green');
        } catch (\Exception $e) {
            CLI::error('Error: ' . $e->getMessage());
        }
    }
}
