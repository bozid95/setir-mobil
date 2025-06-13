<?php

require __DIR__ . '/vendor/autoload.php';

try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

    echo "=== Quick Student Enhancement Check ===\n\n";

    // Check database columns
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('students');
    echo "Current students table columns:\n";
    foreach ($columns as $column) {
        echo "- $column\n";
    }

    // Check if new columns exist
    $newColumns = ['gender', 'place_of_birth', 'date_of_birth', 'occupation'];
    echo "\nNew columns status:\n";
    foreach ($newColumns as $column) {
        $exists = in_array($column, $columns);
        echo "- $column: " . ($exists ? "✅ EXISTS" : "❌ MISSING") . "\n";
    }

    echo "\n=== Check Complete ===\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
