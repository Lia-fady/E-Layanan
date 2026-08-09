<?php
$refDir = 'c:/Users/Ahmad Hisyam/Downloads/Projectmagang_dr/public/Projectmagang_dr_bidang/app';
$mainDir = 'c:/Users/Ahmad Hisyam/Downloads/Projectmagang_dr/app';

$targets = [
    'Controllers/Kabid',
    'Models/Kabid',
    'Views/dashboard/kabid'
];

foreach ($targets as $target) {
    echo "=== $target ===\n";
    $refFiles = glob("$refDir/$target/*");
    $mainFiles = glob("$mainDir/$target/*");
    
    $refBase = array_map('basename', $refFiles);
    $mainBase = array_map('basename', $mainFiles);
    
    $allFiles = array_unique(array_merge($refBase, $mainBase));
    
    foreach ($allFiles as $file) {
        $inRef = in_array($file, $refBase);
        $inMain = in_array($file, $mainBase);
        
        if ($inRef && $inMain) {
            $refPath = "$refDir/$target/$file";
            $mainPath = "$mainDir/$target/$file";
            
            $refSize = filesize($refPath);
            $mainSize = filesize($mainPath);
            
            if ($refSize != $mainSize) {
                echo "[MODIFIED] $file (Ref: $refSize, Main: $mainSize)\n";
            } else {
                echo "[SAME] $file\n";
            }
        } elseif ($inRef) {
            echo "[ONLY IN REF] $file\n";
        } elseif ($inMain) {
            echo "[ONLY IN MAIN] $file\n";
        }
    }
    echo "\n";
}
