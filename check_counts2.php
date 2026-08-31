<?php
$content = file_get_contents('app/Views/mahasiswa/v_detail_permohonan.php');
$if_count = preg_match_all('/if\s*\(.*?\)\s*:/', $content, $m);
$endif_count = preg_match_all('/endif\s*;/', $content, $n);
$foreach_count = preg_match_all('/foreach\s*\(.*?\)\s*:/', $content, $o);
$endforeach_count = preg_match_all('/endforeach\s*;/', $content, $p);

echo "IF: $if_count\n";
echo "ENDIF: $endif_count\n";
echo "FOREACH: $foreach_count\n";
echo "ENDFOREACH: $endforeach_count\n";
