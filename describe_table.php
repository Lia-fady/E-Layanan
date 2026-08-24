<?php
$host = '192.168.133.120';
$db   = 'db_';
$user = 'remote_user';
$pass = '123456';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query("DESCRIBE t_penempatan_magang");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
