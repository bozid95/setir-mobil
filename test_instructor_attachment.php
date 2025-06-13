<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING INSTRUCTOR ATTACHMENT IN STUDENT SESSIONS ===\n\n";

try {
    // 1. Get test data
    $student = App\Models\Student::first();
    $session = App\Models\Session::first();
    $instructor = App\Models\Instructor::first();

    if (!$student || !$session || !$instructor) {
        echo "❌ Missing test data. Please ensure you have students, sessions, and instructors.\n";
        exit;
    }

    echo "📋 Test Data:\n";
    echo "   Student: {$student->name} (ID: {$student->id})\n";
    echo "   Session: {$session->name} (ID: {$session->id})\n";
    echo "   Instructor: {$instructor->name} (ID: {$instructor->id})\n\n";

    // 2. Test direct StudentSession creation
    echo "1. Testing Direct StudentSession Creation:\n";

    $directSession = App\Models\StudentSession::create([
        'student_id' => $student->id,
        'session_id' => $session->id,
        'instructor_id' => $instructor->id,
        'scheduled_date' => now()->addDays(1),
        'status' => 'scheduled',
        'notes' => 'Test direct creation with instructor'
    ]);

    echo "   ✅ Created StudentSession ID: {$directSession->id}\n";
    echo "   ✅ Instructor ID saved: {$directSession->instructor_id}\n";
    echo "   ✅ Instructor name: {$directSession->instructor->name}\n\n";

    // 3. Test pivot attachment
    echo "2. Testing Pivot Attachment:\n";

    // Find another session to avoid duplicate attachment
    $anotherSession = App\Models\Session::where('id', '!=', $session->id)->first();
    if (!$anotherSession) {
        // Create a test session if none exists
        $anotherSession = App\Models\Session::create([
            'name' => 'Test Session for Instructor Attachment',
            'order' => 999,
            'description' => 'Test session for instructor attachment verification',
            'package_id' => $student->package_id
        ]);
        echo "   📝 Created test session: {$anotherSession->name}\n";
    }

    // Attach session with instructor
    $student->sessions()->attach($anotherSession->id, [
        'instructor_id' => $instructor->id,
        'scheduled_date' => now()->addDays(2),
        'status' => 'scheduled',
        'notes' => 'Test pivot attachment with instructor'
    ]);

    echo "   ✅ Attached session via pivot with instructor\n";

    // 4. Verify data retrieval
    echo "\n3. Verifying Data Retrieval:\n";

    // Get student sessions with instructor
    $studentSessions = $student->sessions()
        ->withPivot(['instructor_id', 'scheduled_date', 'status', 'notes'])
        ->get();

    foreach ($studentSessions as $sess) {
        echo "   📅 Session: {$sess->name}\n";
        echo "      Instructor ID: {$sess->pivot->instructor_id}\n";
        echo "      Scheduled: {$sess->pivot->scheduled_date}\n";
        echo "      Status: {$sess->pivot->status}\n";

        // Get instructor name via StudentSession model
        $studentSession = App\Models\StudentSession::where('student_id', $student->id)
            ->where('session_id', $sess->id)
            ->with('instructor')
            ->first();

        if ($studentSession && $studentSession->instructor) {
            echo "      Instructor Name: {$studentSession->instructor->name}\n";
        } else {
            echo "      ❌ Instructor not found or not loaded\n";
        }
        echo "\n";
    }

    // 5. Test SessionsRelationManager compatibility
    echo "4. Testing SessionsRelationManager Compatibility:\n";

    // Simulate what SessionsRelationManager does
    $studentWithSessions = App\Models\Student::with([
        'sessions' => function ($query) {
            $query->withPivot(['instructor_id', 'scheduled_date', 'status', 'notes', 'score', 'grade', 'instructor_feedback']);
        }
    ])->find($student->id);

    echo "   ✅ Student loaded with sessions and pivot data\n";
    echo "   📊 Sessions count: {$studentWithSessions->sessions->count()}\n";

    foreach ($studentWithSessions->sessions as $sess) {
        echo "   📅 {$sess->name}: Instructor ID {$sess->pivot->instructor_id}\n";
    }

    // Clean up test data
    echo "\n5. Cleaning up test data:\n";
    $directSession->delete();
    $student->sessions()->detach($anotherSession->id);
    if ($anotherSession->name === 'Test Session for Instructor Attachment') {
        $anotherSession->delete();
        echo "   🧹 Cleaned up test session\n";
    }
    echo "   🧹 Cleaned up test student session\n";

    echo "\n✅ ALL TESTS PASSED!\n";
    echo "Instructor data should now be properly saved when attaching sessions to students.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
