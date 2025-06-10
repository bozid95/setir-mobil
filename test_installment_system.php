<?php

require_once 'vendor/autoload.php';

use App\Models\Student;
use App\Models\Finance;
use App\Models\Installment;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING INSTALLMENT SYSTEM ===\n\n";

try {
    // Test 1: Show Finance Overview
    echo "1. FINANCE OVERVIEW:\n";
    $finances = Finance::with(['student', 'installments'])->get();

    foreach ($finances as $finance) {
        echo "Student: {$finance->student->name}\n";
        echo "Type: {$finance->type} | Payment: {$finance->payment_type}\n";

        if ($finance->payment_type === 'full') {
            echo "Amount: Rp " . number_format($finance->amount) . " | Status: {$finance->status}\n";
        } else {
            echo "Total: Rp " . number_format($finance->total_amount) . " | Paid: Rp " . number_format($finance->paid_amount) . " | Remaining: Rp " . number_format($finance->remaining_amount)\n";
            echo "Progress: {$finance->payment_progress}% | Installments: {$finance->total_installments}\n";
        }
        echo "---\n";
    }
    echo "\n";

    // Test 2: Show Installment Details
    echo "2. INSTALLMENT DETAILS:\n";
    $installments = Installment::with(['student', 'finance'])->orderBy('due_date')->get();

    foreach ($installments as $installment) {
        $statusColor = match($installment->status) {
            'paid' => '✅',
            'pending' => ($installment->due_date < now() ? '🔴' : '⏳'),
            'overdue' => '🔴',
            default => '⚪'
        };

        echo "{$statusColor} {$installment->student->name} - Installment #{$installment->installment_number}\n";
        echo "   Amount: Rp " . number_format($installment->amount) . " | Due: {$installment->due_date->format('d M Y')}\n";
        echo "   Status: {$installment->status}";
        if ($installment->paid_date) {
            echo " | Paid: {$installment->paid_date->format('d M Y')}";
        }
        echo "\n---\n";
    }
    echo "\n";

    // Test 3: Payment Statistics
    echo "3. PAYMENT STATISTICS:\n";
    $totalRevenue = Finance::where('payment_type', 'full')->where('status', 'paid')->sum('amount');
    $installmentRevenue = Finance::where('payment_type', 'installment')->sum('paid_amount');
    $totalRevenue += $installmentRevenue;

    $pendingInstallments = Installment::where('status', 'pending')->count();
    $overdueInstallments = Installment::where('status', 'pending')
                                    ->where('due_date', '<', now())
                                    ->count();
    $upcomingInstallments = Installment::where('status', 'pending')
                                      ->whereBetween('due_date', [now(), now()->addWeek()])
                                      ->count();

    echo "Total Revenue: Rp " . number_format($totalRevenue) . "\n";
    echo "Pending Installments: {$pendingInstallments}\n";
    echo "Overdue Installments: {$overdueInstallments}\n";
    echo "Due This Week: {$upcomingInstallments}\n\n";

    // Test 4: Student Payment Summary
    echo "4. STUDENT PAYMENT SUMMARY:\n";
    $students = Student::with(['finances.installments'])->get();

    foreach ($students as $student) {
        echo "👤 {$student->name}:\n";

        $totalOwed = 0;
        $totalPaid = 0;

        foreach ($student->finances as $finance) {
            if ($finance->payment_type === 'full') {
                if ($finance->status === 'paid') {
                    $totalPaid += $finance->amount;
                } else {
                    $totalOwed += $finance->amount;
                }
            } else {
                $totalPaid += $finance->paid_amount;
                $totalOwed += $finance->remaining_amount;
            }
        }

        $pendingCount = $student->installments()->where('status', 'pending')->count();
        $overdueCount = $student->installments()
                               ->where('status', 'pending')
                               ->where('due_date', '<', now())
                               ->count();

        echo "   💰 Total Paid: Rp " . number_format($totalPaid) . "\n";
        echo "   💸 Total Owed: Rp " . number_format($totalOwed) . "\n";
        echo "   📋 Pending Installments: {$pendingCount}";
        if ($overdueCount > 0) {
            echo " (⚠️ {$overdueCount} overdue)";
        }
        echo "\n---\n";
    }

    echo "✅ INSTALLMENT SYSTEM TEST COMPLETED SUCCESSFULLY!\n\n";

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
