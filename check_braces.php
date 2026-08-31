<?php
$content = file_get_contents('app/Views/mahasiswa/v_detail_permohonan.php');
$tokens = token_get_all($content);
$balance = 0;
$braceBalance = 0;
foreach ($tokens as $line => $t) {
    if (is_array($t)) {
        if ($t[0] == T_IF) {
            // Check if it's alternative syntax (followed by :)
        }
        if ($t[0] == T_CURLY_OPEN) $braceBalance++;
    } else {
        if ($t == '{') $braceBalance++;
        if ($t == '}') $braceBalance--;
    }
}
echo "Brace balance: $braceBalance\n";
