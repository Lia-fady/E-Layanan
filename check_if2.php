<?php
$content = file_get_contents('app/Views/mahasiswa/v_detail_permohonan.php');
$tokens = token_get_all($content);
$stack = [];
$line = 1;
foreach ($tokens as $t) {
    if (is_array($t)) {
        if ($t[0] == T_IF) {
            // we need to see if it's followed by : or {
        }
    }
}
