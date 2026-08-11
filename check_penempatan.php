<?php
$db = new PDO('mysql:host=localhost;dbname=db_elayanan_akademik_kominfo_final', 'root', '');
$q = $db->query("DESCRIBE t_penempatan_magang");
print_r($q->fetchAll(PDO::FETCH_ASSOC));
