<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    echo "Checking student_sessions table structure:\n";
    $columns = Schema::getColumnListing('student_sessions');
    echo "Columns: " . implode(', ', $columns) . "\n";

    // Check if instructor_id exists
    if (in_array('instructor_id', $columns)) {
        echo "✓ instructor_id column already exists\n";
    } else {
        echo "✗ instructor_id column does not exist\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
