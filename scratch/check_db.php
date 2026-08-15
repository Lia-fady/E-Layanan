<?php
require 'public/index.php';
$db = \Config\Database::connect();
$fields = $db->getFieldNames('t_persetujuan_magang');
echo json_encode($fields);
