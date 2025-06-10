<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "=== CHECKING ACTUAL DATABASE STRUCTURE ===\n\n";

try {
    // Check student_sessions table
    if (Schema::hasTable('student_sessions')) {
        $columns = Schema::getColumnListing('student_sessions');
        echo "✅ student_sessions table exists\n";
        echo "Columns: " . implode(', ', $columns) . "\n";

        // Check specifically for date-related columns
        $dateColumns = ['date', 'scheduled_date'];
        echo "\nDate-related columns found:\n";
        foreach ($dateColumns as $col) {
            if (in_array($col, $columns)) {
                echo "✅ $col column exists\n";
            } else {
                echo "❌ $col column missing\n";
            }
        }
    } else {
        echo "❌ student_sessions table does not exist\n";
    }

    echo "\n" . str_repeat("=", 50) . "\n";
    echo "This will help identify the correct column name to use.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
