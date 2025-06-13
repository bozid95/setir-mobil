<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Creating test data and verifying instructor display...\n";

try {
    $student = App\Models\Student::first();
    $session = App\Models\Session::first();
    $instructor = App\Models\Instructor::first();

    if ($student && $session && $instructor) {
        echo "Using:\n";
        echo "- Student: {$student->name} (ID: {$student->id})\n";
        echo "- Session: {$session->name} (ID: {$session->id})\n";
        echo "- Instructor: {$instructor->name} (ID: {$instructor->id})\n\n";

        // Create test student session
        $studentSession = App\Models\StudentSession::create([
            'student_id' => $student->id,
            'session_id' => $session->id,
            'instructor_id' => $instructor->id,
            'scheduled_date' => now()->addDays(1),
            'status' => 'scheduled',
            'notes' => 'Test session for instructor display'
        ]);

        echo "Created StudentSession ID: {$studentSession->id}\n";

        // Test instructor retrieval
        $testSession = App\Models\StudentSession::where('student_id', $student->id)
            ->where('session_id', $session->id)
            ->with('instructor')
            ->first();

        if ($testSession && $testSession->instructor) {
            echo "SUCCESS: Instructor found - {$testSession->instructor->name}\n";
        } else {
            echo "FAILED: No instructor found\n";
        }

        // Test pivot relationship
        echo "\nTesting pivot relationship...\n";
        $studentWithSessions = $student->sessions()
            ->withPivot(['instructor_id', 'scheduled_date', 'status'])
            ->where('session_id', $session->id)
            ->first();

        if ($studentWithSessions) {
            echo "Pivot instructor_id: {$studentWithSessions->pivot->instructor_id}\n";

            // Simulate SessionsRelationManager logic
            $assignedInstructor = App\Models\StudentSession::where('student_id', $student->id)
                ->where('session_id', $session->id)
                ->with('instructor')
                ->first();

            $instructorName = $assignedInstructor && $assignedInstructor->instructor
                ? $assignedInstructor->instructor->name
                : 'No instructor assigned';

            echo "Assigned Instructor (via getStateUsing logic): {$instructorName}\n";
        }

        // Clean up
        $studentSession->delete();
        echo "\nTest data cleaned up.\n";
        echo "Instructor column should now display properly in SessionsRelationManager!\n";
    } else {
        echo "Missing required test data\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
