<?php
$dir = new RecursiveDirectoryIterator('app/Models');
$iter = new RecursiveIteratorIterator($dir);
foreach ($iter as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getPathname();
        if (strpos($path, 'SuperAdmin') !== false) continue; // Skip SuperAdmin

        $content = file_get_contents($path);
        
        // Careful replacements
        $content = preg_replace("/'deskripsi'/", "'rencana_kegiatan'", $content);
        $content = preg_replace("/'pm\.deskripsi'/", "'pm.rencana_kegiatan'", $content);
        $content = preg_replace("/pm\.deskripsi,/", "pm.rencana_kegiatan,", $content);
        $content = preg_replace("/t_permohonan_magang\.deskripsi,/", "t_permohonan_magang.rencana_kegiatan,", $content);

        file_put_contents($path, $content);
        echo "Updated: $path\n";
    }
}
?>
