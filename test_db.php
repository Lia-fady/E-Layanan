<?php
try {
    $pdo = new PDO('mysql:host=192.168.150.237;dbname=db_elayanan_akademik_kominfo', 'remote_user', '123456');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to 192.168.150.237\n";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "\n";
}
