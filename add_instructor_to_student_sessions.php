<?php

require_once 'vendor/autoload.php';

use App\Models\StudentSession;
use App\Models\Session;
use App\Models\Instructor;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== UPDATING STUDENT SESSIONS WITH DYNAMIC INSTRUCTORS ===\n\n";

try {
    $instructors = Instructor::all();
    $studentSessions = StudentSession::with(['session', 'session.instructor'])->get();

    echo "Found {$studentSessions->count()} student sessions to update...\n\n";

    foreach ($studentSessions as $studentSession) {
        // Jika belum ada instructor_id, assign berdasarkan session instructor atau random
        if (!$studentSession->instructor_id) {
            // 70% kemungkinan menggunakan instructor default dari session
            // 30% kemungkinan menggunakan instructor yang berbeda untuk simulasi fleksibilitas
            if (rand(1, 100) <= 70 && $studentSession->session->instructor_id) {
                $assignedInstructor = $studentSession->session->instructor;
            } else {
                $assignedInstructor = $instructors->random();
            }

            $studentSession->instructor_id = $assignedInstructor->id;
            $studentSession->save();

            echo "✓ Updated student session ID {$studentSession->id}\n";
            echo "  Student: {$studentSession->student->name}\n";
            echo "  Session: {$studentSession->session->title}\n";
            echo "  Default Instructor: {$studentSession->session->instructor->name}\n";
            echo "  Assigned Instructor: {$assignedInstructor->name}\n";
            echo "  Status: " . ($assignedInstructor->id == $studentSession->session->instructor_id ? 'Same as default' : 'Different instructor') . "\n\n";
        }
    }

    echo "=== VERIFICATION ===\n";

    // Verifikasi hasilnya
    $updatedSessions = StudentSession::with(['student', 'session', 'instructor', 'session.instructor'])->get();

    echo "Student Session Summary:\n";
    foreach ($updatedSessions as $ss) {
        echo "• {$ss->student->name} - {$ss->session->title}\n";
        echo "  Default: {$ss->session->instructor->name} | Assigned: {$ss->instructor->name}\n";
        echo "  Score: {$ss->score} | Grade: {$ss->grade}\n\n";
    }

    // Statistik instructor workload
    echo "=== INSTRUCTOR WORKLOAD ANALYSIS ===\n";
    foreach ($instructors as $instructor) {
        $sessionCount = StudentSession::where('instructor_id', $instructor->id)->count();
        echo "👨‍🏫 {$instructor->name}: {$sessionCount} student sessions assigned\n";
    }

    echo "\n✅ Dynamic instructor assignment completed successfully!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
