<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo', 'remote_user', '123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("UPDATE t_persetujuan_magang SET status_persetujuan = 'PERBAIKAN_BERKAS' WHERE status_persetujuan = 'DITOLAK'");
    $stmt->execute();
    echo "Rows updated: " . $stmt->rowCount() . "\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
