<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== REMOVING EMAIL UNIQUE CONSTRAINT ===\n\n";

try {
    // Check if constraint exists
    $constraints = DB::select("SHOW INDEX FROM students WHERE Key_name = 'students_email_unique'");

    if (count($constraints) > 0) {
        echo "Found unique constraint 'students_email_unique' on email column\n";
        echo "Attempting to remove constraint...\n";

        // Drop the unique constraint
        DB::statement("ALTER TABLE students DROP INDEX students_email_unique");
        echo "✓ Successfully removed unique constraint from email column\n";
    } else {
        echo "No unique constraint found on email column\n";
    }

    // Verify the constraint is gone
    $constraints_after = DB::select("SHOW INDEX FROM students WHERE Key_name = 'students_email_unique'");

    if (count($constraints_after) == 0) {
        echo "✓ Confirmed: email column is no longer unique\n";
    } else {
        echo "⚠ Warning: constraint may still exist\n";
    }

    echo "\n=== CONSTRAINT REMOVAL COMPLETE ===\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
