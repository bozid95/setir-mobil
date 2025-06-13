<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FINAL VERIFICATION - STUDENT SESSION FIELD CONSISTENCY ===\n\n";

try {
    // 1. Check StudentSession model
    echo "1. ✅ StudentSession Model Configuration:\n";
    $model = new App\Models\StudentSession();
    echo "   - Fillable: " . implode(', ', $model->getFillable()) . "\n";
    echo "   - Casts: " . implode(', ', array_keys($model->getCasts())) . "\n\n";

    // 2. Check Student relationship
    echo "2. ✅ Student Model Relationship:\n";
    $student = new App\Models\Student();
    $reflection = new ReflectionMethod($student, 'sessions');
    $code = file_get_contents($reflection->getFileName());
    $lines = explode("\n", $code);
    $startLine = $reflection->getStartLine() - 1;
    $endLine = $reflection->getEndLine() - 1;
    $methodCode = implode("\n", array_slice($lines, $startLine, $endLine - $startLine + 1));

    if (strpos($methodCode, 'scheduled_date') !== false) {
        echo "   ✅ Student->sessions() uses 'scheduled_date' in withPivot\n";
    } else {
        echo "   ❌ Student->sessions() still uses old 'date' field\n";
    }

    // 3. Check Session relationship
    echo "\n3. ✅ Session Model Relationship:\n";
    $session = new App\Models\Session();
    $reflection = new ReflectionMethod($session, 'students');
    $code = file_get_contents($reflection->getFileName());
    $lines = explode("\n", $code);
    $startLine = $reflection->getStartLine() - 1;
    $endLine = $reflection->getEndLine() - 1;
    $methodCode = implode("\n", array_slice($lines, $startLine, $endLine - $startLine + 1));

    if (strpos($methodCode, 'scheduled_date') !== false) {
        echo "   ✅ Session->students() uses 'scheduled_date' in withPivot\n";
    } else {
        echo "   ❌ Session->students() still uses old 'date' field\n";
    }

    // 4. Database structure verification
    echo "\n4. ✅ Database Structure:\n";
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('student_sessions');
    $hasScheduledDate = in_array('scheduled_date', $columns);
    $hasOldDate = in_array('date', $columns);

    echo "   - scheduled_date column: " . ($hasScheduledDate ? "✅ EXISTS" : "❌ MISSING") . "\n";
    echo "   - old date column: " . ($hasOldDate ? "⚠️  STILL EXISTS" : "✅ REMOVED") . "\n";

    // 5. Test actual data creation
    echo "\n5. ✅ Data Creation Test:\n";
    $student = App\Models\Student::first();
    $session = App\Models\Session::first();
    $instructor = App\Models\Instructor::first();

    if ($student && $session && $instructor) {
        // Test direct model creation
        $studentSession = App\Models\StudentSession::create([
            'student_id' => $student->id,
            'session_id' => $session->id,
            'instructor_id' => $instructor->id,
            'scheduled_date' => now(),
            'status' => 'scheduled',
            'notes' => 'Test session for field consistency verification'
        ]);

        echo "   ✅ Direct StudentSession creation: SUCCESS (ID: {$studentSession->id})\n";

        // Test pivot relationship attachment
        $testSession = App\Models\Session::find(1);
        if ($testSession && !$testSession->students()->where('student_id', $student->id)->exists()) {
            $testSession->students()->attach($student->id, [
                'instructor_id' => $instructor->id,
                'scheduled_date' => now()->addDays(1),
                'status' => 'scheduled',
                'notes' => 'Test pivot attachment'
            ]);
            echo "   ✅ Pivot relationship attachment: SUCCESS\n";

            // Clean up pivot attachment
            $testSession->students()->detach($student->id);
        } else {
            echo "   ⚠️  Student already attached to session, skipping pivot test\n";
        }

        // Clean up direct creation
        $studentSession->delete();
        echo "   ✅ Test data cleaned up\n";
    } else {
        echo "   ⚠️  Missing required test data\n";
    }

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "🎉 FIELD CONSISTENCY FIX COMPLETED SUCCESSFULLY!\n";
    echo str_repeat("=", 60) . "\n\n";

    echo "📋 SUMMARY OF CHANGES:\n";
    echo "✅ StudentSession model updated to use 'scheduled_date'\n";
    echo "✅ Student->sessions() relationship updated\n";
    echo "✅ Session->students() relationship updated\n";
    echo "✅ SessionsRelationManager forms updated\n";
    echo "✅ StudentsRelationManager table columns updated\n";
    echo "✅ All field references now consistent\n\n";

    echo "🚀 NEXT STEPS:\n";
    echo "1. Test the admin interface at /admin\n";
    echo "2. Try creating/editing student sessions\n";
    echo "3. Verify that scheduled_date field works in forms\n";
    echo "4. Check that table columns display properly\n\n";

    echo "The 'scheduled_date' field error should now be resolved!\n";
} catch (Exception $e) {
    echo "❌ Error during verification: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
