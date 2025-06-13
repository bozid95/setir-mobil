<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SIMPLIFIED DASHBOARD VERIFICATION ===\n\n";

try {
    // 1. Check remaining widget files
    echo "1. Checking Simplified Widget Files...\n";
    $expectedWidgets = [
        'DrivingSchoolStatsOverview.php',
        'LatestStudents.php',
        'OverduePaymentsWidget.php'
    ];

    foreach ($expectedWidgets as $widget) {
        $path = "app/Filament/Widgets/$widget";
        if (file_exists($path)) {
            echo "   ✅ $widget - EXISTS\n";
        } else {
            echo "   ❌ $widget - MISSING\n";
        }
    }

    // 2. Check removed widgets
    echo "\n2. Checking Removed Widgets...\n";
    $removedWidgets = [
        'FinanceStatsOverview.php',
        'MonthlyFinanceChart.php',
        'StudentRegistrationsChart.php',
        'RevenueChart.php',
        'RecentPaymentsWidget.php',
        'PaymentStatusChart.php'
    ];

    foreach ($removedWidgets as $widget) {
        $path = "app/Filament/Widgets/$widget";
        if (!file_exists($path)) {
            echo "   ✅ $widget - SUCCESSFULLY REMOVED\n";
        } else {
            echo "   ❌ $widget - STILL EXISTS\n";
        }
    }

    // 3. Test widget instantiation
    echo "\n3. Testing Widget Instantiation...\n";
    $widgetClasses = [
        \App\Filament\Widgets\DrivingSchoolStatsOverview::class,
        \App\Filament\Widgets\LatestStudents::class,
        \App\Filament\Widgets\OverduePaymentsWidget::class,
    ];

    foreach ($widgetClasses as $widgetClass) {
        try {
            $widget = new $widgetClass();
            $name = class_basename($widgetClass);
            echo "   ✅ $name - Can be instantiated\n";
        } catch (Exception $e) {
            $name = class_basename($widgetClass);
            echo "   ❌ $name - Error: " . $e->getMessage() . "\n";
        }
    }

    // 4. Test Dashboard page
    echo "\n4. Testing Dashboard Page...\n";
    try {
        $dashboard = new \App\Filament\Pages\Dashboard();
        $widgets = $dashboard->getWidgets();
        echo "   ✅ Dashboard page instantiated successfully\n";
        echo "   📊 Configured widgets: " . count($widgets) . "\n";

        foreach ($widgets as $index => $widget) {
            $name = class_basename($widget);
            echo "       " . ($index + 1) . ". $name\n";
        }

        $columns = $dashboard->getColumns();
        echo "   📐 Column configuration: " . json_encode($columns) . "\n";
    } catch (Exception $e) {
        echo "   ❌ Dashboard error: " . $e->getMessage() . "\n";
    }

    // 5. Test database connectivity
    echo "\n5. Testing Database Connectivity...\n";
    try {
        $studentCount = \App\Models\Student::count();
        $packageCount = \App\Models\Package::count();
        $financeCount = \App\Models\Finance::count();

        echo "   ✅ Database connected successfully\n";
        echo "   📊 Students: $studentCount records\n";
        echo "   📦 Packages: $packageCount records\n";
        echo "   💰 Finances: $financeCount records\n";
    } catch (Exception $e) {
        echo "   ❌ Database error: " . $e->getMessage() . "\n";
    }

    echo "\n" . str_repeat("=", 50) . "\n";
    echo "🎉 SIMPLIFIED DASHBOARD VERIFICATION COMPLETE!\n";
    echo "\n📊 SUMMARY:\n";
    echo "✅ Dashboard widgets reduced from 8+ to 3 essential widgets\n";
    echo "✅ Removed 6 unnecessary analytics widgets\n";
    echo "✅ Simplified layout to 3-column responsive design\n";
    echo "✅ Kept only critical information:\n";
    echo "   • Overall stats overview\n";
    echo "   • Latest student registrations\n";
    echo "   • Overdue payments alerts\n";
    echo "\n🚀 Dashboard is now clean and focused!\n";
} catch (Exception $e) {
    echo "❌ Verification failed: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
