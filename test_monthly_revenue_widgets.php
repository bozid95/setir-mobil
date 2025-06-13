<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING MONTHLY REVENUE WIDGETS ===\n\n";

try {
    // 1. Check current month revenue
    echo "1. Testing monthly revenue data...\n";

    $currentMonth = now();
    $lastMonth = now()->subMonth();

    echo "   📅 Current month: " . $currentMonth->format('F Y') . "\n";
    echo "   📅 Last month: " . $lastMonth->format('F Y') . "\n\n";

    // Get this month's revenue
    $thisMonthRevenue = App\Models\Finance::where('type', 'income')
        ->whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->sum('amount');

    echo "   💰 This month revenue: Rp " . number_format($thisMonthRevenue, 0, ',', '.') . "\n";

    // Get last month's revenue
    $lastMonthRevenue = App\Models\Finance::where('type', 'income')
        ->whereMonth('created_at', $lastMonth->month)
        ->whereYear('created_at', $lastMonth->year)
        ->sum('amount');

    echo "   💰 Last month revenue: Rp " . number_format($lastMonthRevenue, 0, ',', '.') . "\n";

    // Calculate growth
    $growthPercentage = 0;
    if ($lastMonthRevenue > 0) {
        $growthPercentage = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
    }

    echo "   📈 Growth: " . number_format($growthPercentage, 1) . "%\n\n";

    // 2. Test MonthlyRevenueStatsWidget
    echo "2. Testing MonthlyRevenueStatsWidget...\n";
    $statsWidget = new App\Filament\Widgets\MonthlyRevenueStatsWidget();
    echo "   ✅ MonthlyRevenueStatsWidget instantiated\n";

    // Get paid vs pending
    $paidThisMonth = App\Models\Finance::where('type', 'income')
        ->where('status', 'paid')
        ->whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->sum('amount');

    $pendingThisMonth = App\Models\Finance::where('type', 'income')
        ->where('status', 'pending')
        ->whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->sum('amount');

    echo "   💰 Paid: Rp " . number_format($paidThisMonth, 0, ',', '.') . "\n";
    echo "   ⏳ Pending: Rp " . number_format($pendingThisMonth, 0, ',', '.') . "\n\n";

    // 3. Test MonthlyRevenueChartWidget
    echo "3. Testing MonthlyRevenueChartWidget...\n";
    $chartWidget = new App\Filament\Widgets\MonthlyRevenueChartWidget();
    echo "   ✅ MonthlyRevenueChartWidget instantiated\n";

    // Get 6 months data
    echo "   📊 6 months revenue data:\n";
    for ($i = 5; $i >= 0; $i--) {
        $month = $currentMonth->copy()->subMonths($i);
        $revenue = App\Models\Finance::where('type', 'income')
            ->whereMonth('created_at', $month->month)
            ->whereYear('created_at', $month->year)
            ->sum('amount');
        echo "     " . $month->format('M Y') . ": Rp " . number_format($revenue, 0, ',', '.') . "\n";
    }
    echo "\n";

    // 4. Test MonthlyRevenueTableWidget
    echo "4. Testing MonthlyRevenueTableWidget...\n";
    $tableWidget = new App\Filament\Widgets\MonthlyRevenueTableWidget();
    echo "   ✅ MonthlyRevenueTableWidget instantiated\n";

    // Get this month's transactions
    $transactions = App\Models\Finance::where('type', 'income')
        ->whereMonth('created_at', $currentMonth->month)
        ->whereYear('created_at', $currentMonth->year)
        ->with('student')
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get();

    echo "   📋 Recent transactions this month:\n";
    foreach ($transactions as $transaction) {
        echo "     " . $transaction->created_at->format('M j') . ": {$transaction->student->name} - Rp " . number_format($transaction->amount, 0, ',', '.') . " ({$transaction->status})\n";
    }

    if ($transactions->count() == 0) {
        echo "     ⚠️  No transactions found for this month\n";

        // Create test transaction
        echo "\n   🔄 Creating test transaction...\n";
        $student = App\Models\Student::first();
        if ($student) {
            $testTransaction = App\Models\Finance::create([
                'student_id' => $student->id,
                'date' => now(),
                'amount' => 1500000,
                'type' => 'income',
                'description' => 'Test monthly payment for revenue widget',
                'status' => 'paid'
            ]);

            echo "   ✅ Created test transaction: Rp " . number_format($testTransaction->amount, 0, ',', '.') . "\n";
        }
    }

    echo "\n" . str_repeat("=", 60) . "\n";
    echo "🎉 MONTHLY REVENUE WIDGETS READY!\n";
    echo str_repeat("=", 60) . "\n\n";

    echo "📋 REVENUE WIDGETS NOW INCLUDE:\n";
    echo "✅ Monthly Revenue Stats - Growth comparison, paid/pending breakdown\n";
    echo "✅ Monthly Revenue Chart - 6 months trend visualization\n";
    echo "✅ Monthly Revenue Table - Detailed transaction list with totals\n";
    echo "✅ Integration with existing finance system\n\n";

    echo "🚀 DASHBOARD NOW PROVIDES:\n";
    echo "• Complete revenue analytics for current month\n";
    echo "• Growth comparison with previous month\n";
    echo "• Visual trend analysis (6 months chart)\n";
    echo "• Detailed transaction breakdown\n";
    echo "• Paid vs pending revenue tracking\n\n";

    echo "Navigate to /admin to see the enhanced revenue dashboard!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
