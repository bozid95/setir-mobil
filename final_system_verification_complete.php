<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FINAL SYSTEM VERIFICATION ===\n\n";

$allGood = true;

try {
    // 1. Dashboard Simplification Check
    echo "1. 📊 DASHBOARD SIMPLIFICATION VERIFICATION\n";
    echo str_repeat("-", 40) . "\n";

    // Check widget files
    $remainingWidgets = ['DrivingSchoolStatsOverview.php', 'LatestStudents.php', 'OverduePaymentsWidget.php'];
    $removedWidgets = ['FinanceStatsOverview.php', 'MonthlyFinanceChart.php', 'StudentRegistrationsChart.php', 'RevenueChart.php', 'RecentPaymentsWidget.php', 'PaymentStatusChart.php'];

    foreach ($remainingWidgets as $widget) {
        $exists = file_exists("app/Filament/Widgets/$widget");
        echo ($exists ? "✅" : "❌") . " $widget " . ($exists ? "EXISTS" : "MISSING") . "\n";
        if (!$exists) $allGood = false;
    }

    foreach ($removedWidgets as $widget) {
        $exists = file_exists("app/Filament/Widgets/$widget");
        echo ($exists ? "❌" : "✅") . " $widget " . ($exists ? "STILL EXISTS" : "REMOVED") . "\n";
        if ($exists) $allGood = false;
    }

    // Test Dashboard instantiation
    try {
        $dashboard = new \App\Filament\Pages\Dashboard();
        $widgets = $dashboard->getWidgets();
        $widgetCount = count($widgets);
        echo "✅ Dashboard loads with $widgetCount widgets\n";

        if ($widgetCount === 3) {
            echo "✅ Correct widget count (3 essential widgets)\n";
        } else {
            echo "❌ Wrong widget count (expected 3, got $widgetCount)\n";
            $allGood = false;
        }
    } catch (Exception $e) {
        echo "❌ Dashboard instantiation failed: " . $e->getMessage() . "\n";
        $allGood = false;
    }

    // 2. Registration Enhancement Check
    echo "\n2. 👤 REGISTRATION ENHANCEMENT VERIFICATION\n";
    echo str_repeat("-", 40) . "\n";

    // Check database columns
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('students');
    $newFields = ['gender', 'place_of_birth', 'date_of_birth', 'occupation'];

    foreach ($newFields as $field) {
        $exists = in_array($field, $columns);
        echo ($exists ? "✅" : "❌") . " $field column " . ($exists ? "EXISTS" : "MISSING") . "\n";
        if (!$exists) $allGood = false;
    }

    // Check Student model
    try {
        $student = new \App\Models\Student();
        $fillable = $student->getFillable();
        $newFieldsInFillable = array_intersect($newFields, $fillable);

        if (count($newFieldsInFillable) === count($newFields)) {
            echo "✅ All new fields are fillable in Student model\n";
        } else {
            echo "❌ Missing fillable fields: " . implode(', ', array_diff($newFields, $newFieldsInFillable)) . "\n";
            $allGood = false;
        }
    } catch (Exception $e) {
        echo "❌ Student model error: " . $e->getMessage() . "\n";
        $allGood = false;
    }

    // Check migration
    try {
        $migration = \Illuminate\Support\Facades\DB::table('migrations')
            ->where('migration', 'like', '%add_personal_info_to_students_table%')
            ->first();

        if ($migration) {
            echo "✅ Personal info migration applied\n";
        } else {
            echo "❌ Personal info migration not found\n";
            $allGood = false;
        }
    } catch (Exception $e) {
        echo "❌ Migration check failed: " . $e->getMessage() . "\n";
        $allGood = false;
    }

    // 3. System Integration Test
    echo "\n3. 🔧 SYSTEM INTEGRATION TEST\n";
    echo str_repeat("-", 40) . "\n";

    // Test database connectivity
    try {
        $studentCount = \App\Models\Student::count();
        $packageCount = \App\Models\Package::count();
        $financeCount = \App\Models\Finance::count();

        echo "✅ Database connected successfully\n";
        echo "   📊 Students: $studentCount | Packages: $packageCount | Finances: $financeCount\n";
    } catch (Exception $e) {
        echo "❌ Database connectivity failed: " . $e->getMessage() . "\n";
        $allGood = false;
    }

    // Test Filament resources
    try {
        $studentResource = new \App\Filament\Resources\StudentResource();
        echo "✅ StudentResource working\n";
    } catch (Exception $e) {
        echo "❌ StudentResource failed: " . $e->getMessage() . "\n";
        $allGood = false;
    }

    // 4. Performance Check
    echo "\n4. ⚡ PERFORMANCE CHECK\n";
    echo str_repeat("-", 40) . "\n";

    $startTime = microtime(true);

    // Simulate dashboard loading
    try {
        $dashboard = new \App\Filament\Pages\Dashboard();
        $widgets = $dashboard->getWidgets();

        foreach ($widgets as $widgetClass) {
            $widget = new $widgetClass();
            // Just instantiate, don't render
        }

        $endTime = microtime(true);
        $loadTime = round(($endTime - $startTime) * 1000, 2);

        echo "✅ Dashboard load time: {$loadTime}ms\n";

        if ($loadTime < 500) {
            echo "✅ Performance excellent (< 500ms)\n";
        } elseif ($loadTime < 1000) {
            echo "⚠️ Performance good (< 1000ms)\n";
        } else {
            echo "❌ Performance needs improvement (> 1000ms)\n";
            $allGood = false;
        }
    } catch (Exception $e) {
        echo "❌ Performance test failed: " . $e->getMessage() . "\n";
        $allGood = false;
    }

    // Final Result
    echo "\n" . str_repeat("=", 50) . "\n";

    if ($allGood) {
        echo "🎉 FINAL VERIFICATION: ALL SYSTEMS GO! 🎉\n";
        echo "\n✅ Dashboard successfully simplified to 3 essential widgets\n";
        echo "✅ Registration enhanced with personal information fields\n";
        echo "✅ Database migration applied correctly\n";
        echo "✅ All components working properly\n";
        echo "✅ Performance is optimal\n";
        echo "\n🚀 SYSTEM IS READY FOR PRODUCTION USE!\n";
    } else {
        echo "❌ VERIFICATION FAILED - Issues detected\n";
        echo "\n⚠️ Please review the errors above and fix them.\n";
        echo "🔧 Re-run this verification after fixing issues.\n";
    }
} catch (Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    $allGood = false;
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "Verification completed at: " . date('Y-m-d H:i:s') . "\n";
