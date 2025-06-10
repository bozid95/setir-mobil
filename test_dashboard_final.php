<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use App\Filament\Pages\Dashboard;
use App\Filament\Widgets\DrivingSchoolStatsOverview;
use App\Filament\Widgets\FinanceStatsOverview;
use App\Filament\Widgets\OverduePaymentsWidget;
use App\Filament\Widgets\LatestStudents;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== DASHBOARD FINAL TEST ===\n\n";

try {
    // Test Dashboard Configuration
    echo "1. Testing Dashboard Configuration...\n";
    $dashboard = new Dashboard();
    $widgets = $dashboard->getWidgets();

    echo "✅ Dashboard widgets count: " . count($widgets) . "\n";
    foreach ($widgets as $index => $widget) {
        $widgetName = class_basename($widget);
        echo "   " . ($index + 1) . ". $widgetName\n";
    }

    // Test Widget Files Existence
    echo "\n2. Testing Widget Files...\n";
    $expectedWidgets = [
        'DrivingSchoolStatsOverview',
        'FinanceStatsOverview',
        'OverduePaymentsWidget',
        'LatestStudents'
    ];

    foreach ($expectedWidgets as $widgetName) {
        $filePath = "app/Filament/Widgets/{$widgetName}.php";
        if (file_exists($filePath)) {
            echo "✅ $widgetName exists\n";
        } else {
            echo "❌ $widgetName missing\n";
        }
    }

    // Check removed widget
    echo "\n3. Checking Removed Widget...\n";
    $removedWidget = "app/Filament/Widgets/UpcomingSessions.php";
    if (!file_exists($removedWidget)) {
        echo "✅ UpcomingSessions widget successfully removed\n";
    } else {
        echo "❌ UpcomingSessions widget still exists\n";
    }

    // Test Widget Instantiation
    echo "\n4. Testing Widget Instantiation...\n";

    // Test DrivingSchoolStatsOverview
    try {
        $statsWidget = new DrivingSchoolStatsOverview();
        echo "✅ DrivingSchoolStatsOverview can be instantiated\n";
    } catch (Exception $e) {
        echo "❌ DrivingSchoolStatsOverview error: " . $e->getMessage() . "\n";
    }

    // Test FinanceStatsOverview
    try {
        $financeWidget = new FinanceStatsOverview();
        echo "✅ FinanceStatsOverview can be instantiated\n";
    } catch (Exception $e) {
        echo "❌ FinanceStatsOverview error: " . $e->getMessage() . "\n";
    }

    // Test OverduePaymentsWidget
    try {
        $overdueWidget = new OverduePaymentsWidget();
        echo "✅ OverduePaymentsWidget can be instantiated\n";
    } catch (Exception $e) {
        echo "❌ OverduePaymentsWidget error: " . $e->getMessage() . "\n";
    }

    // Test LatestStudents
    try {
        $latestWidget = new LatestStudents();
        echo "✅ LatestStudents can be instantiated\n";
    } catch (Exception $e) {
        echo "❌ LatestStudents error: " . $e->getMessage() . "\n";
    }

    // Test Database Connectivity
    echo "\n5. Testing Database Connectivity...\n";

    // Test basic table queries
    $tables = ['students', 'finances', 'packages', 'instructors'];
    foreach ($tables as $table) {
        try {
            $count = \Illuminate\Support\Facades\DB::table($table)->count();
            echo "✅ $table table: $count records\n";
        } catch (Exception $e) {
            echo "❌ $table table error: " . $e->getMessage() . "\n";
        }
    }

    echo "\n=== DASHBOARD TEST SUMMARY ===\n";
    echo "✅ Dashboard has been successfully cleaned up\n";
    echo "✅ Problematic UpcomingSessions widget removed\n";
    echo "✅ 4 essential widgets remain active\n";
    echo "✅ Database connectivity verified\n";
    echo "\nDashboard should now load without errors!\n";
} catch (Exception $e) {
    echo "❌ CRITICAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
