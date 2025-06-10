<?php

require_once 'vendor/autoload.php';

use App\Models\Student;
use App\Models\Finance;
use App\Models\Installment;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING INSTALLMENT SYSTEM ===\n\n";

try {
    // Test 1: Finance Overview
    echo "1. FINANCE OVERVIEW:\n";
    $finances = Finance::with(['student', 'installments'])->get();

    foreach ($finances as $finance) {
        echo "Student: " . $finance->student->name . "\n";
        echo "Type: " . $finance->type . " | Payment: " . $finance->payment_type . "\n";

        if ($finance->payment_type === 'full') {
            echo "Amount: Rp " . number_format($finance->amount) . "\n";
            echo "Status: " . $finance->status . "\n";
        } else {
            echo "Total: Rp " . number_format($finance->total_amount) . "\n";
            echo "Paid: Rp " . number_format($finance->paid_amount) . "\n";
            echo "Remaining: Rp " . number_format($finance->remaining_amount) . "\n";
            echo "Progress: " . $finance->payment_progress . "%\n";
            echo "Installments: " . $finance->total_installments . "\n";
        }
        echo "---\n";
    }
    echo "\n";

    // Test 2: Installment Details
    echo "2. INSTALLMENT DETAILS:\n";
    $installments = Installment::with(['student', 'finance'])->orderBy('due_date')->get();

    foreach ($installments as $installment) {
        $status_icon = $installment->status === 'paid' ? '✅' : '⏳';

        echo $status_icon . " " . $installment->student->name . " - Installment #" . $installment->installment_number . "\n";
        echo "   Amount: Rp " . number_format($installment->amount) . "\n";
        echo "   Due: " . $installment->due_date->format('d M Y') . "\n";
        echo "   Status: " . $installment->status . "\n";
        if ($installment->paid_date) {
            echo "   Paid: " . $installment->paid_date->format('d M Y') . "\n";
        }
        echo "---\n";
    }
    echo "\n";

    // Test 3: Statistics
    echo "3. PAYMENT STATISTICS:\n";
    $totalFinances = Finance::count();
    $installmentFinances = Finance::where('payment_type', 'installment')->count();
    $totalInstallments = Installment::count();
    $paidInstallments = Installment::where('status', 'paid')->count();
    $pendingInstallments = Installment::where('status', 'pending')->count();

    echo "Total Finance Records: " . $totalFinances . "\n";
    echo "Installment Finance Records: " . $installmentFinances . "\n";
    echo "Total Installments: " . $totalInstallments . "\n";
    echo "Paid Installments: " . $paidInstallments . "\n";
    echo "Pending Installments: " . $pendingInstallments . "\n\n";

    echo "✅ INSTALLMENT SYSTEM TEST COMPLETED!\n\n";

    echo "🎯 NEXT STEPS:\n";
    echo "1. Access admin panel: http://localhost:8000/admin\n";
    echo "2. Navigate to Finance > Finances to manage payments\n";
    echo "3. Navigate to Finance > Installments to track installments\n";
    echo "4. Use 'Generate Installments' action for installment payments\n";
    echo "5. Use 'Mark as Paid' action to record payments\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
