<?php
$conn = new mysqli('127.0.0.1', 'root', '', 'db_elayanan_akademik_kominfo_final(1)');
if ($conn->connect_error) die("Connection failed");

// List semua model files di root Models/
$rootModels = [
    'FakultasModel',
    'FilePermohonanMagangModel',
    'FilePermohonanModel',
    'FileProsesMagangModel',
    'InstansiMahasiswaModel',
    'InstansiPendidikanModel',
    'KuotaBidangModel',
    'LogPermohonanModel',
    'LogbookMagangModel',
    'MahasiswaModel',
    'MasterKelasModel',
    'MenuModel',
    'MenuPrivilegeModel',
    'PasswordResetModel',
    'PenempatanMagangModel',
    'PermohonanMagangModel',
    'PersetujuanMagangModel',
    'ProdiModel',
    'UserGroupModel',
    'UserMahasiswaModel',
];

echo "=== ANALISIS MODEL YANG BERCECERAN DI ROOT Models/ ===\n\n";

foreach ($rootModels as $model) {
    echo "--- {$model}.php ---\n";
    
    // Cari siapa yang menggunakan model ini
    $searchDir = 'C:\\Users\\lenovo\\Downloads\\Projectmagang_antigravity\\app';
    $pattern = "App\\Models\\{$model}";
    
    // Use shell command to search
    $cmd = 'findstr /s /n /c:"' . $pattern . '" "' . $searchDir . '\\*.php" 2>nul';
    $output = [];
    exec($cmd, $output);
    
    if (empty($output)) {
        echo "  ⚠️  TIDAK DIGUNAKAN OLEH SIAPAPUN\n";
    } else {
        foreach ($output as $line) {
            // Clean up path for readability
            $line = str_replace($searchDir . '\\', '', $line);
            // Skip the model file itself
            if (strpos($line, "Models\\{$model}.php") !== false) continue;
            echo "  📌 {$line}\n";
        }
    }
    echo "\n";
}
