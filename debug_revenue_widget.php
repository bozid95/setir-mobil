<?php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Finance;

echo "=== DEBUG REVENUE WIDGET ===\n\n";

// Check all finance records
echo "1. ALL FINANCE RECORDS:\n";
$allFinances = Finance::all();
foreach ($allFinances as $finance) {
    echo "ID: {$finance->id} | Type: {$finance->type} | Status: {$finance->status} | Amount: {$finance->amount} | Date: {$finance->created_at}\n";
}

echo "\n2. INCOME RECORDS ONLY:\n";
$incomes = Finance::where('type', 'income')->get();
foreach ($incomes as $finance) {
    echo "ID: {$finance->id} | Status: {$finance->status} | Amount: {$finance->amount} | Date: {$finance->created_at}\n";
}

echo "\n3. THIS MONTH CALCULATION:\n";
$currentMonth = now();
echo "Current Month: {$currentMonth->month}, Year: {$currentMonth->year}\n";

// This month revenue (all income)
$thisMonthRevenue = Finance::where('type', 'income')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');

echo "Total This Month Revenue: Rp " . number_format($thisMonthRevenue, 0, ',', '.') . "\n";

// Paid this month
$paidThisMonth = Finance::where('type', 'income')
    ->where('status', 'paid')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');

echo "Paid This Month: Rp " . number_format($paidThisMonth, 0, ',', '.') . "\n";

// Pending this month
$pendingThisMonth = Finance::where('type', 'income')
    ->where('status', 'pending')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->sum('amount');

echo "Pending This Month: Rp " . number_format($pendingThisMonth, 0, ',', '.') . "\n";

echo "\n4. DETAILED BREAKDOWN:\n";
$thisMonthRecords = Finance::where('type', 'income')
    ->whereMonth('created_at', $currentMonth->month)
    ->whereYear('created_at', $currentMonth->year)
    ->get();

echo "Records found this month: " . $thisMonthRecords->count() . "\n";
foreach ($thisMonthRecords as $record) {
    echo "- ID: {$record->id} | Status: {$record->status} | Amount: {$record->amount} | Date: {$record->created_at}\n";
}

echo "\n5. STATUS VALUES CHECK:\n";
$distinctStatuses = Finance::where('type', 'income')->distinct()->pluck('status');
echo "Distinct status values: " . $distinctStatuses->implode(', ') . "\n";

echo "\n6. CHECKING FOR CASE SENSITIVITY:\n";
$paidExact = Finance::where('type', 'income')->where('status', 'paid')->count();
$paidLower = Finance::where('type', 'income')->whereRaw('LOWER(status) = ?', ['paid'])->count();
echo "Exact 'paid' match: {$paidExact}\n";
echo "Case insensitive 'paid' match: {$paidLower}\n";

echo "\n=== END DEBUG ===\n";
