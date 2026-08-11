<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MigrateManual extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'migrate:manual';
    protected $description = 'Manually migrate and seed m_kelas.';

    public function run(array $params)
    {
        $db = \Config\Database::connect();
        
        // 1. Create table
        $db->query("CREATE TABLE IF NOT EXISTS `m_kelas` (
            `id_kelas` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `nama_kelas` varchar(50) NOT NULL,
            `status` varchar(20) NOT NULL DEFAULT 'AKTIF',
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            PRIMARY KEY (`id_kelas`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        CLI::write("Table m_kelas created.", "green");

        // 2. Add id_kelas to t_instansi_mahasiswa
        try {
            $db->query("ALTER TABLE `t_instansi_mahasiswa` ADD COLUMN `id_kelas` int(11) unsigned DEFAULT NULL AFTER `semester`");
            CLI::write("Column id_kelas added.", "green");
        } catch (\Exception $e) {
            CLI::write("Column id_kelas might already exist or error: " . $e->getMessage(), "yellow");
        }

        // 3. Seed data
        $count = $db->table('m_kelas')->countAllResults();
        if ($count == 0) {
            $now = date('Y-m-d H:i:s');
            $data = [
                ['nama_kelas' => '10', 'status' => 'AKTIF', 'created_at' => $now, 'updated_at' => $now],
                ['nama_kelas' => '11', 'status' => 'AKTIF', 'created_at' => $now, 'updated_at' => $now],
                ['nama_kelas' => '12', 'status' => 'AKTIF', 'created_at' => $now, 'updated_at' => $now],
                ['nama_kelas' => 'Lainnya', 'status' => 'AKTIF', 'created_at' => $now, 'updated_at' => $now],
            ];
            $db->table('m_kelas')->insertBatch($data);
            CLI::write("Data seeded.", "green");
        } else {
            CLI::write("Data already seeded.", "yellow");
        }
    }
}
