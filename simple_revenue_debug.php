<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Finance;

try {
    echo "=== REVENUE DEBUG ===\n";

    // Check total finance records
    $total = Finance::count();
    echo "Total Finance Records: {$total}\n";

    // Check income records
    $incomes = Finance::where('type', 'income')->get();
    echo "Income Records: " . $incomes->count() . "\n";

    foreach ($incomes as $income) {
        echo "- ID: {$income->id}, Status: '{$income->status}', Amount: {$income->amount}, Date: {$income->created_at}\n";
    }

    // Check paid records
    $paid = Finance::where('type', 'income')->where('status', 'paid')->get();
    echo "\nPaid Records: " . $paid->count() . "\n";

    $paidSum = Finance::where('type', 'income')->where('status', 'paid')->sum('amount');
    echo "Paid Sum: {$paidSum}\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
