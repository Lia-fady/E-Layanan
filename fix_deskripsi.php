<?php
$host = 'localhost';
$dbname = 'db_elayanan_akademik_kominfo';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Cek kolom yang ada di tabel
    $stmt = $pdo->query("DESCRIBE t_permohonan_magang");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Kolom di t_permohonan_magang:\n";
    foreach ($columns as $col) {
        echo "  - $col\n";
    }

    if (in_array('deskripsi_magang', $columns) && !in_array('deskripsi', $columns)) {
        echo "\nKolom 'deskripsi_magang' ditemukan, melakukan rename ke 'deskripsi'...\n";
        $pdo->exec("ALTER TABLE t_permohonan_magang CHANGE deskripsi_magang deskripsi TEXT NULL");
        echo "Berhasil! Kolom telah diubah menjadi 'deskripsi'.\n";

        // Update migration tracker
        $pdo->exec("INSERT INTO migrations (version, class, `group`, namespace, time, batch)
            VALUES ('2026-07-28-100000', 'App\\\\Database\\\\Migrations\\\\RenameDeskripsiMagangColumn', 'default', 'App', UNIX_TIMESTAMP(), (SELECT COALESCE(MAX(batch),0)+1 FROM migrations m2))
            ON DUPLICATE KEY UPDATE batch = batch");
        echo "Migration tracker diperbarui.\n";
    } elseif (in_array('deskripsi', $columns)) {
        echo "\nKolom 'deskripsi' sudah ada. Tidak perlu perubahan.\n";
    } else {
        echo "\nKolom tidak ditemukan. Periksa nama tabel atau database.\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
