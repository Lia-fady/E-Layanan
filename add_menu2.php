<?php
$host = 'localhost';
$db   = 'db_';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get max position for parent_id = 0
    $stmt = $pdo->query("SELECT MAX(position) as max_position FROM c_menus WHERE id_parent = 0");
    $row = $stmt->fetch();
    $position = $row['max_position'] + 1;

    // Insert menu Sertifikat
    $sql = "INSERT INTO c_menus (id_parent, name, url, position, icon, status, target_blank) 
            VALUES (0, 'Sertifikat Magang', 'kabid/sertifikat', $position, 'bi bi-award', 1, 0)";
    $pdo->exec($sql);
    $id_menu = $pdo->lastInsertId();

    echo "Menu inserted with ID: $id_menu\n";

    // Kabid is usually id_user_group = 3 (Wait, let's just query it)
    $stmt = $pdo->query("SELECT id_user_group FROM m_user_group WHERE group_name LIKE '%Kabid%' OR group_name LIKE '%Kepala Bidang%'");
    $kabid_group = $stmt->fetchColumn();
    if (!$kabid_group) {
        $kabid_group = 2; 
    }

    $sql = "INSERT INTO c_menus_privileges (id_menu, id_user_group) VALUES ($id_menu, $kabid_group)";
    $pdo->exec($sql);

    echo "Privilege inserted for Group $kabid_group (Kabid)\n";

} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
