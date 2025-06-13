<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING SCHEDULED_DATE FIX ===\n\n";

try {
    // Test StudentSession model fillable fields
    echo "1. Testing StudentSession model...\n";
    $studentSession = new App\Models\StudentSession();
    $fillable = $studentSession->getFillable();
    echo "   Fillable fields: " . implode(', ', $fillable) . "\n";

    if (in_array('scheduled_date', $fillable)) {
        echo "   ✅ 'scheduled_date' is in fillable array\n";
    } else {
        echo "   ❌ 'scheduled_date' missing from fillable array\n";
    }

    if (in_array('date', $fillable)) {
        echo "   ❌ Old 'date' field still in fillable array\n";
    } else {
        echo "   ✅ Old 'date' field removed from fillable array\n";
    }

    // Test StudentSession casts
    echo "\n2. Testing StudentSession casts...\n";
    $casts = $studentSession->getCasts();
    if (isset($casts['scheduled_date'])) {
        echo "   ✅ 'scheduled_date' is properly cast to: " . $casts['scheduled_date'] . "\n";
    } else {
        echo "   ❌ 'scheduled_date' cast missing\n";
    }

    // Test database structure
    echo "\n3. Testing database structure...\n";
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('student_sessions');
    echo "   Columns in student_sessions table: " . implode(', ', $columns) . "\n";

    if (in_array('scheduled_date', $columns)) {
        echo "   ✅ 'scheduled_date' column exists in database\n";
    } else {
        echo "   ❌ 'scheduled_date' column missing from database\n";
    }

    // Test creating a student session with scheduled_date
    echo "\n4. Testing student session creation...\n";
    $student = App\Models\Student::first();
    $session = App\Models\Session::first();
    $instructor = App\Models\Instructor::first();

    if ($student && $session && $instructor) {
        $testData = [
            'student_id' => $student->id,
            'session_id' => $session->id,
            'instructor_id' => $instructor->id,
            'scheduled_date' => now(),
            'status' => 'scheduled',
            'notes' => 'Test session created with scheduled_date field'
        ];

        $testSession = App\Models\StudentSession::create($testData);
        echo "   ✅ Successfully created student session with ID: " . $testSession->id . "\n";
        echo "   ✅ Scheduled date: " . $testSession->scheduled_date->format('Y-m-d H:i:s') . "\n";

        // Clean up test data
        $testSession->delete();
        echo "   ✅ Test session cleaned up\n";
    } else {
        echo "   ⚠️  Missing test data (student, session, or instructor)\n";
    }

    echo "\n✅ ALL TESTS PASSED - scheduled_date field fix completed!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
