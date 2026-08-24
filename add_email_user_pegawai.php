<?php

require 'vendor/autoload.php';

use Config\Database;

$db = Database::connect();

// Add email column if it does not exist
$fields = $db->getFieldData('c_user_pegawai');
$hasEmail = false;
foreach ($fields as $field) {
    if ($field->name === 'email') {
        $hasEmail = true;
        break;
    }
}

if (! $hasEmail) {
    $db->query('ALTER TABLE c_user_pegawai ADD COLUMN email VARCHAR(100) NULL AFTER nip');
    echo "Email column added.\n";
} else {
    echo "Email column already exists.\n";
}
?>
