<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== DATABASE STRUCTURE CHECK ===\n\n";

    // Check driving_sessions table
    if (Schema::hasTable('driving_sessions')) {
        $columns = Schema::getColumnListing('driving_sessions');
        echo "DRIVING_SESSIONS table columns:\n";
        foreach ($columns as $column) {
            echo "  - $column\n";
        }
        echo "\n";
    }

    // Check students table
    if (Schema::hasTable('students')) {
        $columns = Schema::getColumnListing('students');
        echo "STUDENTS table columns:\n";
        foreach ($columns as $column) {
            echo "  - $column\n";
        }
        echo "\n";
    }

    // Check student_sessions table
    if (Schema::hasTable('student_sessions')) {
        $columns = Schema::getColumnListing('student_sessions');
        echo "STUDENT_SESSIONS table columns:\n";
        foreach ($columns as $column) {
            echo "  - $column\n";
        }
        echo "\n";
    }

    echo "=== ANALYSIS ===\n";

    // Check if instructor_id exists in driving_sessions
    $sessionColumns = Schema::getColumnListing('driving_sessions');
    if (in_array('instructor_id', $sessionColumns)) {
        echo "✓ instructor_id column exists in driving_sessions\n";
    } else {
        echo "✗ instructor_id column missing in driving_sessions\n";
    }

    // Check if instructor_id exists in students
    $studentColumns = Schema::getColumnListing('students');
    if (in_array('instructor_id', $studentColumns)) {
        echo "! instructor_id column still exists in students (needs removal)\n";
    } else {
        echo "✓ instructor_id column removed from students\n";
    }

    // Check grading columns in student_sessions
    $sessionStudentColumns = Schema::getColumnListing('student_sessions');
    $gradingColumns = ['score', 'grade', 'instructor_feedback'];
    foreach ($gradingColumns as $column) {
        if (in_array($column, $sessionStudentColumns)) {
            echo "✓ $column column exists in student_sessions\n";
        } else {
            echo "✗ $column column missing in student_sessions\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
