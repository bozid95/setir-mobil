<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== CHECKING EXISTING DATA ===\n\n";

    // Check packages
    $packages = DB::table('packages')->get();
    echo "PACKAGES (" . $packages->count() . " records):\n";
    foreach ($packages as $package) {
        echo "  ID: {$package->id}, Name: {$package->name}\n";
    }
    echo "\n";

    // Check instructors
    $instructors = DB::table('instructors')->get();
    echo "INSTRUCTORS (" . $instructors->count() . " records):\n";
    foreach ($instructors as $instructor) {
        echo "  ID: {$instructor->id}, Name: {$instructor->name}\n";
    }
    echo "\n";

    // Check students
    $students = DB::table('students')->get();
    echo "STUDENTS (" . $students->count() . " records):\n";
    foreach ($students as $student) {
        echo "  ID: {$student->id}, Name: {$student->name}, Package: {$student->package_id}\n";
    }
    echo "\n";

    // Check driving_sessions
    $sessions = DB::table('driving_sessions')->get();
    echo "DRIVING_SESSIONS (" . $sessions->count() . " records):\n";
    foreach ($sessions as $session) {
        echo "  ID: {$session->id}, Package: {$session->package_id}, Instructor: {$session->instructor_id}, Title: {$session->title}\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
