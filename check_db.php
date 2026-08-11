<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo_final', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Tables:\n";
    $stmt = $pdo->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        echo $row[0] . "\n";
    }

    echo "\nm_kecamatan schema:\n";
    $stmt = $pdo->query("DESCRIBE m_kecamatan");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
    
    echo "\nm_kecamatan sample:\n";
    $stmt = $pdo->query("SELECT * FROM m_kecamatan LIMIT 1");
    print_r($stmt->fetch(PDO::FETCH_ASSOC));

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
