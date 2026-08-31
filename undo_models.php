<?php
$dir = new RecursiveDirectoryIterator('app/Models');
$iter = new RecursiveIteratorIterator($dir);
foreach ($iter as $file) {
    if ($file->getExtension() === 'php') {
        $path = $file->getPathname();
        if (strpos($path, 'SuperAdmin') !== false) continue;

        $content = file_get_contents($path);
        
        $newContent = str_replace(
            ["'rencana_kegiatan'", "'pm.rencana_kegiatan'", "t_permohonan_magang.rencana_kegiatan,"],
            ["'deskripsi'", "'pm.deskripsi'", "t_permohonan_magang.deskripsi,"],
            $content
        );

        if ($content !== $newContent) {
            file_put_contents($path, $newContent);
            echo "Reverted: $path\n";
        }
    }
}
?>
