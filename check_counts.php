<?php
$content = file_get_contents('app/Views/mahasiswa/v_detail_permohonan.php');
$if_count = preg_match_all('/<\?php\s+if\s*\(.*?\)\s*:\s*\?>/s', $content);
$elseif_count = preg_match_all('/<\?php\s+elseif\s*\(.*?\)\s*:\s*\?>/s', $content);
$else_count = preg_match_all('/<\?php\s+else\s*:\s*\?>/s', $content);
$endif_count = preg_match_all('/<\?php\s+endif\s*;\s*\?>/s', $content);

$foreach_count = preg_match_all('/<\?php\s+foreach\s*\(.*?\)\s*:\s*\?>/s', $content);
$endforeach_count = preg_match_all('/<\?php\s+endforeach\s*;\s*\?>/s', $content);

echo "IF: $if_count\n";
echo "ELSEIF: $elseif_count\n";
echo "ELSE: $else_count\n";
echo "ENDIF: $endif_count\n";
echo "FOREACH: $foreach_count\n";
echo "ENDFOREACH: $endforeach_count\n";
