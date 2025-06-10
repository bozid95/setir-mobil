<?php

require_once 'vendor/autoload.php';

use App\Models\Package;
use App\Models\Instructor;
use App\Models\Material;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentSession;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING RELATIONSHIPS ===\n\n";

try {
    // Test 1: Instructor -> Sessions
    echo "1. Testing Instructor -> Sessions relationship:\n";
    $instructor = Instructor::first();
    $sessions = $instructor->sessions;
    echo "   Instructor: {$instructor->name}\n";
    echo "   Number of sessions: " . $sessions->count() . "\n";
    foreach ($sessions as $session) {
        echo "   - {$session->title}\n";
    }
    echo "\n";

    // Test 2: Session -> Instructor
    echo "2. Testing Session -> Instructor relationship:\n";
    $session = Session::first();
    $instructor = $session->instructor;
    echo "   Session: {$session->title}\n";
    echo "   Instructor: {$instructor->name}\n\n";

    // Test 3: Student -> Sessions (through StudentSession)
    echo "3. Testing Student -> Sessions relationship:\n";
    $student = Student::first();
    $sessions = $student->sessions;
    echo "   Student: {$student->name}\n";
    echo "   Number of sessions: " . $sessions->count() . "\n";
    foreach ($sessions as $session) {
        echo "   - {$session->title}\n";
    }
    echo "\n";

    // Test 4: Session -> Students (through StudentSession)
    echo "4. Testing Session -> Students relationship:\n";
    $session = Session::first();
    $students = $session->students;
    echo "   Session: {$session->title}\n";
    echo "   Number of students: " . $students->count() . "\n";
    foreach ($students as $student) {
        echo "   - {$student->name}\n";
    }
    echo "\n";

    // Test 5: Student -> Package
    echo "5. Testing Student -> Package relationship:\n";
    $student = Student::first();
    $package = $student->package;
    echo "   Student: {$student->name}\n";
    echo "   Package: {$package->name}\n\n";

    // Test 6: Package -> Sessions
    echo "6. Testing Package -> Sessions relationship:\n";
    $package = Package::first();
    $sessions = $package->sessions;
    echo "   Package: {$package->name}\n";
    echo "   Number of sessions: " . $sessions->count() . "\n";
    foreach ($sessions as $session) {
        echo "   - {$session->title} (Instructor: {$session->instructor->name})\n";
    }
    echo "\n";

    // Test 7: StudentSession with grades
    echo "7. Testing StudentSession with grading data:\n";
    $studentSessions = StudentSession::with(['student', 'session', 'session.instructor'])->take(3)->get();
    foreach ($studentSessions as $ss) {
        echo "   Student: {$ss->student->name}\n";
        echo "   Session: {$ss->session->title}\n";
        echo "   Instructor: {$ss->session->instructor->name}\n";
        echo "   Score: {$ss->score}\n";
        echo "   Grade: {$ss->grade}\n";
        echo "   Feedback: {$ss->instructor_feedback}\n";
        echo "   Status: {$ss->status}\n";
        echo "   ---\n";
    }
    echo "\n";

    // Test 8: Instructor -> Students (through sessions)
    echo "8. Testing Instructor -> Students relationship (through sessions):\n";
    $instructor = Instructor::first();
    echo "   Instructor: {$instructor->name}\n";

    // Get students through sessions
    $students = collect();
    foreach ($instructor->sessions as $session) {
        foreach ($session->students as $student) {
            $students->push($student);
        }
    }
    $uniqueStudents = $students->unique('id');
    echo "   Number of unique students: " . $uniqueStudents->count() . "\n";
    foreach ($uniqueStudents as $student) {
        echo "   - {$student->name}\n";
    }
    echo "\n";

    // Test 9: Data counts
    echo "9. Data counts:\n";
    echo "   Packages: " . Package::count() . "\n";
    echo "   Instructors: " . Instructor::count() . "\n";
    echo "   Students: " . Student::count() . "\n";
    echo "   Sessions: " . Session::count() . "\n";
    echo "   Student Sessions: " . StudentSession::count() . "\n";
    echo "   Materials: " . Material::count() . "\n";
    echo "\n";

    echo "=== ALL TESTS COMPLETED SUCCESSFULLY ===\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
