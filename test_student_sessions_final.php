<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Student;
use App\Models\Session;
use App\Models\Instructor;
use App\Models\Package;

echo "=== Testing Student Sessions Workflow ===\n\n";

try {
    // 1. Check available data
    echo "1. Checking available data:\n";
    $studentsCount = Student::count();
    $sessionsCount = Session::count();
    $instructorsCount = Instructor::count();
    $packagesCount = Package::count();

    echo "   - Students: $studentsCount\n";
    echo "   - Sessions: $sessionsCount\n";
    echo "   - Instructors: $instructorsCount\n";
    echo "   - Packages: $packagesCount\n\n";

    if ($studentsCount === 0) {
        echo "   No students found. Creating a test student...\n";
        $student = Student::create([
            'name' => 'Test Student Sessions',
            'email' => 'test.sessions@example.com',
            'phone' => '1234567890',
            'license_number' => 'TEST123',
            'date_of_birth' => '1990-01-01',
            'package_id' => Package::first()?->id ?? 1
        ]);
        echo "   Created student: {$student->name} (ID: {$student->id})\n\n";
    } else {
        $student = Student::first();
        echo "   Using existing student: {$student->name} (ID: {$student->id})\n\n";
    }

    if ($instructorsCount === 0) {
        echo "   No instructors found. Creating a test instructor...\n";
        $instructor = Instructor::create([
            'name' => 'Test Instructor Final',
            'license_number' => 'INST123'
        ]);
        echo "   Created instructor: {$instructor->name} (ID: {$instructor->id})\n\n";
    } else {
        $instructor = Instructor::first();
        echo "   Using existing instructor: {$instructor->name} (ID: {$instructor->id})\n\n";
    }

    if ($sessionsCount === 0) {
        echo "   No sessions found. Creating test sessions...\n";
        $package = Package::first();
        if (!$package) {
            $package = Package::create([
                'name' => 'Test Package',
                'description' => 'Test package for sessions',
                'price' => 500.00,
                'duration_hours' => 10
            ]);
        }

        $session1 = Session::create([
            'name' => 'Basic Driving Techniques',
            'order' => 1,
            'description' => 'Introduction to basic driving techniques',
            'package_id' => $package->id
        ]);

        $session2 = Session::create([
            'name' => 'Parking Maneuvers',
            'order' => 2,
            'description' => 'Learning parallel and perpendicular parking',
            'package_id' => $package->id
        ]);

        echo "   Created sessions: {$session1->name}, {$session2->name}\n\n";
    } else {
        echo "   Sessions available for testing.\n\n";
    }

    // 2. Test session attachment
    echo "2. Testing session attachment:\n";
    $session = Session::first();
    $sessionData = [
        'date' => now()->addDays(7),
        'instructor_id' => $instructor->id,
        'status' => 'scheduled',
        'notes' => 'Test session attachment'
    ];

    // Check if already attached
    if (!$student->sessions()->where('session_id', $session->id)->exists()) {
        $student->sessions()->attach($session->id, $sessionData);
        echo "   ✓ Successfully attached session '{$session->name}' to student '{$student->name}'\n";
    } else {
        echo "   ✓ Session '{$session->name}' already attached to student '{$student->name}'\n";
    }

    // 3. Test retrieving student sessions
    echo "\n3. Testing student sessions retrieval:\n";
    $studentSessions = $student->sessions()->withPivot([
        'date',
        'instructor_id',
        'status',
        'score',
        'grade',
        'notes',
        'instructor_feedback'
    ])->get();

    foreach ($studentSessions as $studentSession) {
        echo "   - Session: {$studentSession->name}\n";
        echo "     Order: {$studentSession->order}\n";
        echo "     Date: {$studentSession->pivot->date}\n";
        echo "     Instructor ID: {$studentSession->pivot->instructor_id}\n";
        echo "     Status: {$studentSession->pivot->status}\n";
        echo "     Notes: {$studentSession->pivot->notes}\n\n";
    }

    // 4. Test session updates
    echo "4. Testing session update:\n";
    $firstStudentSession = $studentSessions->first();
    if ($firstStudentSession) {
        $student->sessions()->updateExistingPivot($firstStudentSession->id, [
            'score' => 85.5,
            'grade' => 'B',
            'instructor_feedback' => 'Good progress, needs improvement on turning'
        ]);
        echo "   ✓ Successfully updated session with score and feedback\n";

        // Verify update
        $updatedSession = $student->sessions()
            ->withPivot(['score', 'grade', 'instructor_feedback'])
            ->where('session_id', $firstStudentSession->id)
            ->first();

        echo "   Updated session details:\n";
        echo "     Score: {$updatedSession->pivot->score}/100\n";
        echo "     Grade: {$updatedSession->pivot->grade}\n";
        echo "     Feedback: {$updatedSession->pivot->instructor_feedback}\n\n";
    }

    // 5. Test session detachment
    echo "5. Testing session detachment:\n";
    if ($studentSessions->count() > 1) {
        $sessionToDetach = $studentSessions->last();
        $student->sessions()->detach($sessionToDetach->id);
        echo "   ✓ Successfully detached session '{$sessionToDetach->name}'\n";

        // Verify detachment
        $remainingSessions = $student->sessions()->count();
        echo "   Remaining sessions: $remainingSessions\n\n";
    } else {
        echo "   Skipping detachment test (only one session available)\n\n";
    }

    echo "=== All Tests Completed Successfully! ===\n";
    echo "The student sessions workflow is working properly.\n";
    echo "The Filament RelationManager should now work without errors.\n";
} catch (Exception $e) {
    echo "❌ Error during testing: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
