<?php

include 'vendor/autoload.php';

$app = include 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Finance;

echo "=== WIDGET REVENUE TEST ===\n\n";

$currentMonth = now();
echo "Testing for month: {$currentMonth->month}, Year: {$currentMonth->year}\n\n";

// Test new query
$thisMonthRevenue = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');

echo "✅ This Month Total Revenue: Rp " . number_format($thisMonthRevenue, 0, ',', '.') . "\n";

$paidThisMonth = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
    ->where('status', 'paid')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');

echo "✅ This Month Paid Revenue: Rp " . number_format($paidThisMonth, 0, ',', '.') . "\n";

$pendingThisMonth = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
    ->where('status', 'pending')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');

echo "✅ This Month Pending Revenue: Rp " . number_format($pendingThisMonth, 0, ',', '.') . "\n";

$transactionCount = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->count();

echo "✅ This Month Transaction Count: {$transactionCount}\n\n";

echo "=== DETAILED BREAKDOWN ===\n";
$records = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->get();

foreach ($records as $record) {
    echo "- {$record->type}: {$record->status} - Rp " . number_format($record->amount, 0, ',', '.') . " ({$record->created_at})\n";
}

echo "\n=== CHART DATA TEST ===\n";
for ($i = 2; $i >= 0; $i--) {
    $month = $currentMonth->copy()->subMonths($i);
    $revenue = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
        ->whereMonth('created_at', $month->month)
        ->whereYear('created_at', $month->year)
        ->sum('amount');

    echo "{$month->format('M Y')}: Rp " . number_format($revenue, 0, ',', '.') . "\n";
}
