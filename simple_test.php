<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== SIMPLE REGISTRATION TEST ===\n\n";

try {
    // Check if packages exist
    $packages = \App\Models\Package::all();
    echo "Found " . $packages->count() . " packages:\n";
    foreach ($packages as $package) {
        echo "  - {$package->name} (ID: {$package->id})\n";
    }

    // Test simple student creation
    $student = new \App\Models\Student();
    $student->name = 'Test Student Simple';
    $student->email = 'redodo@gmail.com';
    $student->package_id = 1;
    $student->save();

    echo "\n✓ Student created successfully!\n";
    echo "  ID: {$student->id}\n";
    echo "  Name: {$student->name}\n";
    echo "  Email: {$student->email}\n";
    echo "  Unique Code: {$student->unique_code}\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "File: " . $e->getFile() . "\n";
}
