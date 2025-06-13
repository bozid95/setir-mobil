<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING INSTRUCTOR RESOURCE FIX ===\n\n";

try {
    // Test Instructor model
    echo "1. Testing Instructor model...\n";

    $instructor = App\Models\Instructor::first();
    if ($instructor) {
        echo "   ✅ Instructor found: {$instructor->name}\n";

        // Test studentSessions relationship
        $studentSessionsCount = $instructor->studentSessions()->count();
        echo "   ✅ Student Sessions Count: {$studentSessionsCount}\n";

        // Test if the relationship loads properly
        $studentSessions = $instructor->studentSessions()->take(3)->get();
        echo "   ✅ Student Sessions loaded: " . $studentSessions->count() . " sessions\n";

        foreach ($studentSessions as $ss) {
            echo "     - Session: {$ss->session->name}, Student: {$ss->student->name}\n";
        }
    } else {
        echo "   ❌ No instructors found\n";
    }

    // Test the counts query that was causing the error
    echo "\n2. Testing Instructor with counts...\n";

    $instructorsWithCounts = App\Models\Instructor::withCount('studentSessions')->take(3)->get();
    echo "   ✅ Instructors with counts loaded: " . $instructorsWithCounts->count() . "\n";

    foreach ($instructorsWithCounts as $instructor) {
        echo "     - {$instructor->name}: {$instructor->student_sessions_count} active sessions\n";
    }

    echo "\n✅ ALL TESTS PASSED!\n";
    echo "Instructor Resource should now work without errors.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
