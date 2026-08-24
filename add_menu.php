<?php
$host = 'localhost';
$db   = 'db_';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get max urutan
    $stmt = $pdo->query("SELECT MAX(urutan) as max_urutan FROM m_menu WHERE parent_id = 0");
    $row = $stmt->fetch();
    $urutan = $row['max_urutan'] + 1;

    // Insert menu Sertifikat
    $sql = "INSERT INTO m_menu (name, url, icon, parent_id, is_header, urutan, status_aktif) 
            VALUES ('Sertifikat Magang', 'kabid/sertifikat', 'bi bi-award', 0, 0, $urutan, 1)";
    $pdo->exec($sql);
    $id_menu = $pdo->lastInsertId();

    echo "Menu inserted with ID: $id_menu\n";

    // Insert privilege for Kabid (id_group = 3?)
    // Let's get Kabid group id
    $stmt = $pdo->query("SELECT id_user_group FROM m_user_group WHERE group_name LIKE '%Kabid%' OR group_name LIKE '%Kepala Bidang%'");
    $kabid_group = $stmt->fetchColumn();
    if (!$kabid_group) $kabid_group = 2; // Usually 2 is Kabid

    $sql = "INSERT INTO m_menu_privilege (id_menu, id_user_group, can_view, can_add, can_edit, can_delete) 
            VALUES ($id_menu, 2, 1, 1, 1, 1)";
    $pdo->exec($sql);
 
    echo "Privilege inserted for Group 2 (Kabid)\n";

} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
       