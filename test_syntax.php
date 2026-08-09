<?php
// Script to test syntax of all Kabid files
$mainDir = 'c:/Users/Ahmad Hisyam/Downloads/Projectmagang_dr/app';

$targets = [
    'Controllers/Kabid/*.php',
    'Models/Kabid/*.php',
];

$errors = 0;
foreach ($targets as $target) {
    $files = glob("$mainDir/$target");
    foreach ($files as $file) {
        $output = [];
        $return_var = 0;
        exec("php -l \"$file\"", $output, $return_var);
        if ($return_var !== 0) {
            echo "Syntax error in $file:\n" . implode("\n", $output) . "\n\n";
            $errors++;
        }
    }
}
if ($errors == 0) {
    echo "No syntax errors found in Kabid models and controllers.\n";
}
