<?php

// Delete all resource files first
$resourceFiles = [
    'app/Filament/Resources/MaterialResource.php',
    'app/Filament/Resources/MaterialResource',
    'app/Filament/Resources/SessionResource.php',
    'app/Filament/Resources/SessionResource',
    'app/Filament/Resources/StudentResource.php',
    'app/Filament/Resources/StudentResource',
    'app/Filament/Resources/FinanceResource.php',
    'app/Filament/Resources/FinanceResource',
    'app/Filament/Resources/PackageResource.php',
    'app/Filament/Resources/PackageResource',
    'app/Filament/Resources/InstructorResource.php',
    'app/Filament/Resources/InstructorResource',
];

foreach ($resourceFiles as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        if (is_dir($path)) {
            // Recursively delete directory
            $it = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($files as $file) {
                if ($file->isDir()) {
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($path);
        } else {
            unlink($path);
        }
        echo "Deleted: $path\n";
    }
}

echo "All resource files have been deleted. Now you can regenerate them.\n";
