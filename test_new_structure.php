<?php

require_once 'vendor/autoload.php';

use App\Models\Session;
use App\Models\Student;
use App\Models\Instructor;
use App\Models\StudentSession;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    echo "=== TESTING NEW STRUCTURE ===\n\n";

    // Test Session model with instructor relationship
    $sessions = Session::with('instructor')->get();
    echo "SESSIONS WITH INSTRUCTORS:\n";
    foreach ($sessions as $session) {
        $instructorName = $session->instructor ? $session->instructor->name : 'No instructor';
        echo "  Session: {$session->title} | Instructor: {$instructorName}\n";
    }
    echo "\n";

    // Test Student model sessions with grading
    $students = Student::with(['sessions' => function ($query) {
        $query->withPivot(['score', 'grade', 'instructor_feedback']);
    }])->get();

    echo "STUDENTS WITH SESSION GRADES:\n";
    foreach ($students as $student) {
        echo "  Student: {$student->name}\n";
        foreach ($student->sessions as $session) {
            $score = $session->pivot->score ?? 'No score';
            $grade = $session->pivot->grade ?? 'No grade';
            $feedback = $session->pivot->instructor_feedback ?? 'No feedback';
            echo "    Session: {$session->title} | Score: {$score} | Grade: {$grade} | Feedback: {$feedback}\n";
        }
    }
    echo "\n";

    // Test Instructor getting students through sessions
    $instructors = Instructor::with(['sessions.students'])->get();
    echo "INSTRUCTORS WITH THEIR STUDENTS:\n";
    foreach ($instructors as $instructor) {
        echo "  Instructor: {$instructor->name}\n";
        $studentNames = [];
        foreach ($instructor->sessions as $session) {
            foreach ($session->students as $student) {
                if (!in_array($student->name, $studentNames)) {
                    $studentNames[] = $student->name;
                }
            }
        }
        if (!empty($studentNames)) {
            echo "    Students: " . implode(', ', $studentNames) . "\n";
        } else {
            echo "    No students\n";
        }
    }

    echo "\n=== ALL TESTS PASSED! ===\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
