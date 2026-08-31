<?php
$content = file_get_contents('app/Views/mahasiswa/v_detail_permohonan.php');
$lines = explode("\n", $content);
foreach ($lines as $i => $line) {
    if (preg_match('/if\s*\(.*?\)\s*:/', $line)) {
        echo ($i + 1) . ": IF\n";
    }
    if (preg_match('/endif\s*;/', $line)) {
        echo ($i + 1) . ": ENDIF\n";
    }
}
