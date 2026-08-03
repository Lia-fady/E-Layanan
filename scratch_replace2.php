<?php
$dir = new RecursiveDirectoryIterator('app');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.php$/', RegexIterator::GET_MATCH);

foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    // Replace all M_Mahasiswa_Mahasiswa with m_mahasiswa except in 'class M_Mahasiswa_Mahasiswa'
    $newContent = preg_replace('/(?<!class\s)M_Mahasiswa_Mahasiswa/', 'm_mahasiswa', $content);
    // Let's also restore the class names in case we messed them up? No, the regex above handles it.
    if ($content !== $newContent) {
        file_put_contents($path, $newContent);
        echo "Updated $path\n";
    }
}
