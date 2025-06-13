<?php

// Simple debug script
include 'vendor/autoload.php';

$app = include 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Finance;

echo "=== FINANCE DEBUG ===\n\n";

$finances = Finance::all();
echo "Total records: " . $finances->count() . "\n\n";

foreach ($finances as $f) {
    echo "ID: {$f->id}\n";
    echo "Type: {$f->type}\n";
    echo "Status: '{$f->status}'\n";
    echo "Amount: {$f->amount}\n";
    echo "Created: {$f->created_at}\n";
    echo "---\n";
}

echo "\n=== INCOME ANALYSIS ===\n";
$incomes = Finance::where('type', 'income')->get();
echo "Income records: " . $incomes->count() . "\n";

$totalIncome = Finance::where('type', 'income')->sum('amount');
echo "Total income amount: {$totalIncome}\n";

$paidIncome = Finance::where('type', 'income')->where('status', 'paid')->sum('amount');
echo "Paid income amount: {$paidIncome}\n";

$pendingIncome = Finance::where('type', 'income')->where('status', 'pending')->sum('amount');
echo "Pending income amount: {$pendingIncome}\n";

echo "\n=== THIS MONTH ===\n";
$currentMonth = now();
echo "Current month: {$currentMonth->month}, Year: {$currentMonth->year}\n";

$thisMonthIncome = Finance::where('type', 'income')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');
echo "This month total income: {$thisMonthIncome}\n";

$thisMonthPaid = Finance::where('type', 'income')
    ->where('status', 'paid')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');
echo "This month paid income: {$thisMonthPaid}\n";
