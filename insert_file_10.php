<?php
$host = '192.168.133.120';
$db   = 'db_';
$user = 'remote_user';
$pass = '123456';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if ID 10 exists
    $stmt = $pdo->query("SELECT * FROM m_file WHERE id_file = 10");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("INSERT INTO m_file (id_file, nama_file, status_aktif) VALUES (10, 'Sertifikat Magang (Piagam)', '1')");
        echo "Inserted ID 10";
    } else {
        echo "ID 10 already exists";
    }
} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
