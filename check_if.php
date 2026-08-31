<?php
$content = file_get_contents('app/Views/mahasiswa/v_detail_permohonan.php');
$lines = explode("\n", $content);
$stack = [];
foreach ($lines as $i => $line) {
    $lineNum = $i + 1;
    if (preg_match('/<\?php\s+if\s*\(.*?\)\s*:\s*\?>/', $line)) {
        echo "$lineNum: IF\n";
        $stack[] = $lineNum;
    } elseif (preg_match('/<\?php\s+elseif\s*\(.*?\)\s*:\s*\?>/', $line)) {
        echo "$lineNum: ELSEIF\n";
    } elseif (preg_match('/<\?php\s+else\s*:\s*\?>/', $line)) {
        echo "$lineNum: ELSE\n";
    } elseif (preg_match('/<\?php\s+endif\s*;\s*\?>/', $line)) {
        $popped = array_pop($stack);
        echo "$lineNum: ENDIF (matches IF at $popped)\n";
    }
}
echo "Unclosed IFs at lines: " . implode(', ', $stack) . "\n";
