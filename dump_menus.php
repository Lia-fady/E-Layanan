<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'db_elayanan_akademik_kominfo_final(1)');
if ($conn->connect_error) die("Connection failed");

$query = "
SELECT g.group as user_group_name, m.name as menu_name, m.url, m.id_parent, m.position, m.id
FROM c_menus_privileges mp 
JOIN c_menus m ON mp.id_menu = m.id 
JOIN c_user_group g ON mp.id_user_group = g.id 
ORDER BY g.id, m.position
";
$result = $conn->query($query);
while($row = $result->fetch_assoc()) {
    echo "{$row['user_group_name']} -> [{$row['id']}] {$row['menu_name']} ({$row['url']}) | Parent: {$row['id_parent']} | Pos: {$row['position']}\n";
}

