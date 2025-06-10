<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "Testing database connection...\n";

    // Check if tables exist
    $tables = ['driving_sessions', 'students', 'student_sessions', 'instructors'];
    foreach ($tables as $table) {
        if (Schema::hasTable($table)) {
            echo "✓ Table '$table' exists\n";
        } else {
            echo "✗ Table '$table' missing\n";
        }
    }

    // Check current columns
    if (Schema::hasTable('driving_sessions')) {
        $columns = Schema::getColumnListing('driving_sessions');
        echo "\nDriving sessions columns: " . implode(', ', $columns) . "\n";
    }

    if (Schema::hasTable('students')) {
        $columns = Schema::getColumnListing('students');
        echo "Students columns: " . implode(', ', $columns) . "\n";
    }

    if (Schema::hasTable('student_sessions')) {
        $columns = Schema::getColumnListing('student_sessions');
        echo "Student sessions columns: " . implode(', ', $columns) . "\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
