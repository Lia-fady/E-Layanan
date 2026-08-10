<?php
$mysqli = new mysqli('localhost', 'root', '');
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

function get_tables($mysqli, $db_name) {
    $tables = [];
    $res = $mysqli->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$db_name'");
    while($row = $res->fetch_assoc()) {
        $tables[] = $row['TABLE_NAME'];
    }
    return $tables;
}

function get_columns($mysqli, $db_name, $table) {
    $columns = [];
    $res = $mysqli->query("SELECT COLUMN_NAME, COLUMN_TYPE, COLUMN_KEY, IS_NULLABLE, COLUMN_DEFAULT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '$db_name' AND TABLE_NAME = '$table'");
    while($row = $res->fetch_assoc()) {
        $columns[$row['COLUMN_NAME']] = $row;
    }
    return $columns;
}

$tables_final = get_tables($mysqli, 'temp_db_final');
$tables_final1 = get_tables($mysqli, 'temp_db_final1');

echo "=== TABLES ONLY IN FINAL ===\n";
$only_final = array_diff($tables_final, $tables_final1);
print_r($only_final);

echo "\n=== TABLES ONLY IN FINAL(1) ===\n";
$only_final1 = array_diff($tables_final1, $tables_final);
print_r($only_final1);

echo "\n=== COLUMN DIFFERENCES IN COMMON TABLES ===\n";
$common_tables = array_intersect($tables_final, $tables_final1);
foreach ($common_tables as $table) {
    $cols_final = get_columns($mysqli, 'temp_db_final', $table);
    $cols_final1 = get_columns($mysqli, 'temp_db_final1', $table);
    
    $cols_only_final = array_diff_key($cols_final, $cols_final1);
    $cols_only_final1 = array_diff_key($cols_final1, $cols_final);
    
    $diff_types = [];
    foreach (array_intersect_key($cols_final, $cols_final1) as $col => $data) {
        if ($cols_final[$col]['COLUMN_TYPE'] !== $cols_final1[$col]['COLUMN_TYPE']) {
            $diff_types[$col] = [
                'final' => $cols_final[$col]['COLUMN_TYPE'],
                'final1' => $cols_final1[$col]['COLUMN_TYPE']
            ];
        }
    }
    
    if (count($cols_only_final) > 0 || count($cols_only_final1) > 0 || count($diff_types) > 0) {
        echo "Table: $table\n";
        if (count($cols_only_final) > 0) {
            echo "  Columns only in final: " . implode(", ", array_keys($cols_only_final)) . "\n";
        }
        if (count($cols_only_final1) > 0) {
            echo "  Columns only in final(1): " . implode(", ", array_keys($cols_only_final1)) . "\n";
        }
        if (count($diff_types) > 0) {
            echo "  Type differences:\n";
            foreach ($diff_types as $col => $diff) {
                echo "    $col: final=" . $diff['final'] . ", final1=" . $diff['final1'] . "\n";
            }
        }
    }
}
$mysqli->close();
