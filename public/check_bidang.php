<?php
$pdo = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo', 'remote_user', '123456');
$stmt = $pdo->query("SHOW TABLES LIKE '%bidang%'");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt2 = $pdo->query("DESCRIBE t_penempatan_magang");
print_r($stmt2->fetchAll(PDO::FETCH_ASSOC));
