<?php
$pdo = new PDO('mysql:host=localhost;dbname=db_;charset=utf8mb4', 'root', '');
$stmt = $pdo->query('SHOW TABLES');
$tables = [];
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}

foreach ($tables as $table) {
    echo "=== TABLE: $table ===\n";
    $stmt2 = $pdo->query("SHOW COLUMNS FROM $table");
    while ($col = $stmt2->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $col['Field'] . " (" . $col['Type'] . ") " . ($col['Key'] == 'PRI' ? 'PK' : '') . "\n";
    }
    echo "\n";
}
?>
