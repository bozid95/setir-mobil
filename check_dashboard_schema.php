<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== DATABASE SCHEMA CHECK ===\n\n";

// Check tables that exist
$tables = ['students', 'packages', 'sessions', 'student_sessions', 'finances', 'instructors'];

foreach ($tables as $table) {
    if (Schema::hasTable($table)) {
        echo "✅ Table '{$table}' exists\n";
        $columns = Schema::getColumnListing($table);
        echo "   Columns: " . implode(', ', $columns) . "\n\n";
    } else {
        echo "❌ Table '{$table}' does not exist\n\n";
    }
}

// Check relationships
echo "=== RELATIONSHIPS CHECK ===\n";

try {
    // Check if students have packages
    $studentsWithPackages = DB::table('students')
        ->join('packages', 'students.package_id', '=', 'packages.id')
        ->count();
    echo "Students with packages: {$studentsWithPackages}\n";

    // Check if packages have sessions
    $packagesWithSessions = DB::table('packages')
        ->join('sessions', 'sessions.package_id', '=', 'packages.id')
        ->count();
    echo "Package-session relationships: {$packagesWithSessions}\n";

    // Check student sessions
    $studentSessions = DB::table('student_sessions')->count();
    echo "Student sessions: {$studentSessions}\n";

    // Check finances
    $finances = DB::table('finances')->count();
    echo "Finance records: {$finances}\n";
} catch (Exception $e) {
    echo "❌ Error checking relationships: " . $e->getMessage() . "\n";
}

echo "\n=== TESTING STUDENT DASHBOARD ACCESS ===\n";

try {
    // Get a student to test with
    $student = DB::table('students')->first();
    if ($student) {
        echo "Test student found: {$student->name} (Code: {$student->unique_code})\n";

        // Check if this student has package
        $package = DB::table('packages')->where('id', $student->package_id)->first();
        if ($package) {
            echo "✅ Student has package: {$package->name}\n";
        } else {
            echo "❌ Student has no package\n";
        }

        // Check dashboard URL
        $dashboardUrl = "http://localhost:8000/student/{$student->unique_code}";
        echo "Dashboard URL: {$dashboardUrl}\n";
    } else {
        echo "❌ No students found in database\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== END CHECK ===\n";
