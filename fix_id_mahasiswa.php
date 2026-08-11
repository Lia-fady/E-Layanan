<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo_final', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Make id_mahasiswa nullable
    $pdo->exec("ALTER TABLE `t_instansi_mahasiswa` MODIFY COLUMN `id_mahasiswa` INT(11) UNSIGNED NULL DEFAULT NULL;");
    
    echo "Column id_mahasiswa is now nullable.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
