<?php
$dir = new RecursiveDirectoryIterator('app');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.php$/', RegexIterator::GET_MATCH);

foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $newContent = str_replace(
        ['\m_mahasiswa', 'new m_mahasiswa'], 
        ['\M_Mahasiswa_Mahasiswa', 'new M_Mahasiswa_Mahasiswa'], 
        $content
    );
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Fixed case back for $path\n";
    }
}
