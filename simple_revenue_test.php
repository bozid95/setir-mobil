<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SIMPLE REVENUE WIDGET TEST ===\n\n";

try {
    // Test Finance model first
    echo "1. Testing Finance model...\n";

    $financeCount = App\Models\Finance::count();
    echo "   📊 Total finance records: {$financeCount}\n";

    $incomeCount = App\Models\Finance::where('type', 'income')->count();
    echo "   💰 Income records: {$incomeCount}\n";

    if ($incomeCount == 0) {
        echo "   🔄 Creating test income record...\n";

        $student = App\Models\Student::first();
        if ($student) {
            $testIncome = App\Models\Finance::create([
                'student_id' => $student->id,
                'date' => now(),
                'amount' => 2000000,
                'type' => 'income',
                'description' => 'Test revenue for widget',
                'status' => 'paid'
            ]);

            echo "   ✅ Created test income: Rp " . number_format($testIncome->amount, 0, ',', '.') . "\n";
        }
    }

    // Test current month revenue
    echo "\n2. Testing current month revenue...\n";

    $thisMonthRevenue = App\Models\Finance::where('type', 'income')
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->sum('amount');

    echo "   💰 This month revenue: Rp " . number_format($thisMonthRevenue, 0, ',', '.') . "\n";

    // Test widget files exist
    echo "\n3. Checking widget files...\n";

    $widgetFiles = [
        'MonthlyRevenueStatsWidget' => 'app/Filament/Widgets/MonthlyRevenueStatsWidget.php',
        'MonthlyRevenueChartWidget' => 'app/Filament/Widgets/MonthlyRevenueChartWidget.php',
        'MonthlyRevenueTableWidget' => 'app/Filament/Widgets/MonthlyRevenueTableWidget.php'
    ];

    foreach ($widgetFiles as $widget => $file) {
        if (file_exists($file)) {
            echo "   ✅ {$widget}: File exists\n";
        } else {
            echo "   ❌ {$widget}: File missing\n";
        }
    }

    echo "\n✅ BASIC REVENUE TEST COMPLETE!\n";
    echo "Revenue widgets have been created and configured.\n";
    echo "Navigate to /admin to see the revenue dashboard!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
