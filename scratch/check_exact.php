<?php
require 'public/index.php';
$db = \Config\Database::connect();
$model = new \App\Models\Mahasiswa\M_PermohonanMagang();
$builder = $model->getStatusPermohonan(null, null); // passing null to id_mahasiswa to just get it
$p = $builder->orderBy('t_permohonan_magang.id_permohonan_magang', 'DESC')->limit(1)->get()->getRowArray();
print_r($p);

$waktuSekre = !empty($p['tanggal_persetujuan']) ? $p['tanggal_persetujuan'] : (!empty($p['tanggal_persetujuan_fallback']) ? $p['tanggal_persetujuan_fallback'] : (!empty($p['waktu_persetujuan_created']) ? $p['waktu_persetujuan_created'] : ''));

echo "\nwaktuSekre: " . $waktuSekre . "\n";
echo "is empty: " . (empty($waktuSekre) ? 'yes' : 'no') . "\n";
