<?php
$content = file_get_contents('c:/Users/lenovo/Downloads/Projectmagang_antigravity/app/Controllers/MahasiswaController.php');
$lines = explode("\n", $content);
foreach($lines as $k => $v) {
    if(strpos($v, 'public function') !== false) echo ($k+1).': '.$v."\n";
}
