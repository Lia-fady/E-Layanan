<?php
$db = new mysqli('localhost', 'root', '', 'db_');
$res = $db->query("SHOW COLUMNS FROM t_permohonan_magang");
while($row = $res->fetch_assoc()) echo $row['Field'] . ' - ' . $row['Type'] . "\n";
echo "===\n";
$res = $db->query("SHOW COLUMNS FROM t_persetujuan_magang");
while($row = $res->fetch_assoc()) echo $row['Field'] . ' - ' . $row['Type'] . "\n";
