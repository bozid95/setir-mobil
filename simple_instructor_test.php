<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Testing instructor display...\n";

try {
    $student = App\Models\Student::first();
    $session = App\Models\Session::first();
    $instructor = App\Models\Instructor::first();

    if ($student && $session && $instructor) {
        echo "Found test data:\n";
        echo "- Student: {$student->name}\n";
        echo "- Session: {$session->name}\n";
        echo "- Instructor: {$instructor->name}\n";

        // Test instructor retrieval
        $studentSession = App\Models\StudentSession::where('student_id', $student->id)
            ->where('session_id', $session->id)
            ->with('instructor')
            ->first();

        if ($studentSession) {
            echo "StudentSession found with instructor: " . ($studentSession->instructor ? $studentSession->instructor->name : 'None') . "\n";
        } else {
            echo "No StudentSession found\n";
        }
    } else {
        echo "Missing test data\n";
    }

    echo "Test completed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
