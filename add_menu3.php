<?php
$host = 'localhost';
$db   = 'db_';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id_menu = 17; // This is the ID we just inserted

    // Let's find the group that has access to 'kabid/penempatan' (id_menu probably around 13 or 14)
    // or just insert for group 2 and 3 and 4 to be safe?
    // Let's insert for group 2, 3, 4, 5. Only those who login as Kabid will see it anyway if it is Kabid's panel.
    $stmt = $pdo->query("SELECT id_user_group FROM c_menus_privileges JOIN c_menus ON c_menus.id = c_menus_privileges.id_menu WHERE c_menus.url LIKE 'kabid%'");
    $groups = $stmt->fetchAll(PDO::FETCH_COLUMN);
    $groups = array_unique($groups);
    
    foreach ($groups as $g) {
        $sql = "INSERT INTO c_menus_privileges (id_menu, id_user_group) VALUES ($id_menu, $g)";
        $pdo->exec($sql);
        echo "Privilege inserted for Group $g\n";
    }

} catch (\PDOException $e) {
    echo "Error: " . $e->getMessage();
}
