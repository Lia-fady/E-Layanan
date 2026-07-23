<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo', 'root', '');
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    foreach($tables as $table) {
        $pdo->exec("DROP TABLE `$table`");
        echo "Dropped $table\n";
    }
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
    echo "All tables dropped successfully.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
