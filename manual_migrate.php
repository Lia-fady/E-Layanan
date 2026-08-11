<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo_final', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // 1. Create m_kelas table
    $pdo->exec("CREATE TABLE IF NOT EXISTS `m_kelas` (
        `id_kelas` int(11) unsigned NOT NULL AUTO_INCREMENT,
        `nama_kelas` varchar(50) NOT NULL,
        `status` varchar(20) NOT NULL DEFAULT 'AKTIF',
        `created_at` datetime DEFAULT NULL,
        `updated_at` datetime DEFAULT NULL,
        PRIMARY KEY (`id_kelas`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    
    // 2. Add id_kelas to m_mahasiswa
    try {
        $pdo->exec("ALTER TABLE `m_mahasiswa` ADD COLUMN `id_kelas` int(11) unsigned DEFAULT NULL AFTER `semester`");
    } catch(PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            echo "Column id_kelas already exists.\n";
        } else {
            throw $e;
        }
    }

    // 3. Seed m_kelas
    $stmt = $pdo->query("SELECT COUNT(*) FROM `m_kelas`");
    $count = $stmt->fetchColumn();
    if ($count == 0) {
        $now = date('Y-m-d H:i:s');
        $pdo->exec("INSERT INTO `m_kelas` (`nama_kelas`, `status`, `created_at`, `updated_at`) VALUES 
            ('10', 'AKTIF', '$now', '$now'),
            ('11', 'AKTIF', '$now', '$now'),
            ('12', 'AKTIF', '$now', '$now'),
            ('Lainnya', 'AKTIF', '$now', '$now')
        ");
        echo "Data seeded successfully.\n";
    } else {
        echo "Data already seeded.\n";
    }

    echo "Migration completed manually.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
