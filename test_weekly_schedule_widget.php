<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING WEEKLY SCHEDULE WIDGET ===\n\n";

try {
    // 1. Check current week range
    echo "1. Testing week date range...\n";
    $startOfWeek = now()->startOfWeek();
    $endOfWeek = now()->endOfWeek();

    echo "   📅 This week: {$startOfWeek->format('M j, Y')} - {$endOfWeek->format('M j, Y')}\n";
    echo "   📅 Start: {$startOfWeek->format('Y-m-d H:i:s')}\n";
    echo "   📅 End: {$endOfWeek->format('Y-m-d H:i:s')}\n\n";

    // 2. Check existing student sessions for this week
    echo "2. Checking existing sessions for this week...\n";

    $weeklySessionsQuery = App\Models\StudentSession::whereBetween('scheduled_date', [
        $startOfWeek,
        $endOfWeek
    ]);

    $weeklySessionsCount = $weeklySessionsQuery->count();
    echo "   📊 Sessions this week: {$weeklySessionsCount}\n";

    if ($weeklySessionsCount > 0) {
        $weeklySessions = $weeklySessionsQuery
            ->with(['student', 'session', 'instructor'])
            ->orderBy('scheduled_date')
            ->get();

        foreach ($weeklySessions as $session) {
            echo "   📅 {$session->scheduled_date->format('D, M j - H:i')}: {$session->student->name} - {$session->session->name}\n";
            echo "      👨‍🏫 Instructor: " . ($session->instructor ? $session->instructor->name : 'Not assigned') . "\n";
            echo "      📝 Status: {$session->status}\n\n";
        }
    } else {
        echo "   ⚠️  No sessions scheduled for this week\n";

        // Create some test sessions for this week
        echo "\n3. Creating test sessions for this week...\n";

        $student = App\Models\Student::first();
        $session = App\Models\Session::first();
        $instructor = App\Models\Instructor::first();

        if ($student && $session && $instructor) {
            // Create sessions for different days this week
            $testSessions = [
                [
                    'scheduled_date' => now()->startOfWeek()->addDays(1)->setTime(9, 0), // Monday 9 AM
                    'status' => 'scheduled',
                    'notes' => 'Morning driving lesson'
                ],
                [
                    'scheduled_date' => now()->startOfWeek()->addDays(3)->setTime(14, 30), // Wednesday 2:30 PM
                    'status' => 'scheduled',
                    'notes' => 'Afternoon practice session'
                ],
                [
                    'scheduled_date' => now()->startOfWeek()->addDays(5)->setTime(10, 15), // Friday 10:15 AM
                    'status' => 'scheduled',
                    'notes' => 'End of week review'
                ]
            ];

            foreach ($testSessions as $index => $sessionData) {
                $testSession = App\Models\StudentSession::create([
                    'student_id' => $student->id,
                    'session_id' => $session->id,
                    'instructor_id' => $instructor->id,
                    'scheduled_date' => $sessionData['scheduled_date'],
                    'status' => $sessionData['status'],
                    'notes' => $sessionData['notes']
                ]);

                echo "   ✅ Created test session: {$sessionData['scheduled_date']->format('D, M j - H:i')}\n";
            }

            echo "\n   📊 Weekly sessions now: " . App\Models\StudentSession::whereBetween('scheduled_date', [$startOfWeek, $endOfWeek])->count() . "\n";
        }
    }

    // 4. Test the stats overview update
    echo "\n4. Testing stats overview...\n";

    $statsOverview = new App\Filament\Widgets\DrivingSchoolStatsOverview();
    echo "   ✅ DrivingSchoolStatsOverview widget can be instantiated\n";

    // Test the weekly schedule count
    $weeklyCount = App\Models\StudentSession::whereBetween('scheduled_date', [
        now()->startOfWeek(),
        now()->endOfWeek()
    ])->count();

    echo "   📊 This Week's Schedule count: {$weeklyCount}\n";

    echo "\n✅ WIDGET TESTING COMPLETE!\n";
    echo "The weekly schedule widget should now display sessions for this week.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
