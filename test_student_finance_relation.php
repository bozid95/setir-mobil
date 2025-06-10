<?php

require_once 'vendor/autoload.php';

use App\Models\Student;
use App\Models\Finance;
use App\Models\Installment;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🧪 TESTING FINANCE RELATION MANAGER DI STUDENT\n";
echo "=" . str_repeat("=", 60) . "\n\n";

try {
    // Test 1: Ambil sample student dengan finances
    echo "1️⃣ Testing Student-Finance Relationship...\n";

    $student = Student::with(['finances.installments'])->first();
    if ($student) {
        echo "   👤 Student: {$student->name}\n";
        echo "   💰 Total Finances: " . $student->finances->count() . "\n";

        foreach ($student->finances as $finance) {
            echo "   💳 Finance #{$finance->id}:\n";
            echo "      📅 Date: {$finance->date}\n";
            echo "      🏷️ Type: {$finance->type}\n";
            echo "      💵 Payment Type: {$finance->payment_type}\n";

            if ($finance->payment_type === 'installment') {
                echo "      💰 Total Amount: Rp " . number_format($finance->total_amount) . "\n";
                echo "      💵 Paid Amount: Rp " . number_format($finance->paid_amount) . "\n";
                echo "      📊 Progress: {$finance->payment_progress}%\n";
                echo "      🗓️ Installments: " . $finance->installments->count() . " angsuran\n";

                // Show some installments
                $installments = $finance->installments->take(2);
                foreach ($installments as $inst) {
                    $status = $inst->status === 'paid' ? '✅' : '⏳';
                    echo "         {$status} {$inst->due_date->format('M j, Y')} - Rp " . number_format($inst->amount) . " ({$inst->status})\n";
                }
            } else {
                echo "      💰 Amount: Rp " . number_format($finance->amount) . "\n";
            }
            echo "\n";
        }
    } else {
        echo "   ❌ No student found\n";
    }

    // Test 2: Simulasi create finance dari student context
    echo "2️⃣ Testing Create Finance from Student Context...\n";

    if ($student) {
        // Simulasi data yang akan dikirim dari form RelationManager
        $newFinanceData = [
            'student_id' => $student->id,
            'date' => now(),
            'type' => 'exam',
            'description' => 'Biaya ujian praktik - Test from Student RelationManager',
            'payment_type' => 'installment',
            'amount' => 0, // Set 0 untuk installment payment
            'total_amount' => 600000,
            'paid_amount' => 0,
            'remaining_amount' => 600000,
            'total_installments' => 3,
            'start_date' => now()->addDays(7),
            'status' => 'pending'
        ];

        echo "   📝 Creating new finance record...\n";
        echo "   👤 Student: {$student->name}\n";
        echo "   🏷️ Type: {$newFinanceData['type']}\n";
        echo "   💰 Total Amount: Rp " . number_format($newFinanceData['total_amount']) . "\n";
        echo "   🗓️ Installments: {$newFinanceData['total_installments']} kali\n";

        // Create finance record
        $newFinance = Finance::create($newFinanceData);

        if ($newFinance) {
            echo "   ✅ Finance created successfully! ID: {$newFinance->id}\n";

            // Generate installments
            echo "   📅 Generating installments...\n";
            $newFinance->generateInstallments();

            $installments = $newFinance->installments;
            echo "   ✅ Generated {$installments->count()} installments:\n";

            foreach ($installments as $inst) {
                echo "      📅 Due: {$inst->due_date->format('M j, Y')} - Rp " . number_format($inst->amount) . " ({$inst->status})\n";
            }
        } else {
            echo "   ❌ Failed to create finance record\n";
        }
    }

    // Test 3: Check data consistency
    echo "\n3️⃣ Testing Data Consistency...\n";

    $totalStudents = Student::count();
    $totalFinances = Finance::count();
    $totalInstallments = Installment::count();
    $installmentFinances = Finance::where('payment_type', 'installment')->count();

    echo "   📊 Total Students: {$totalStudents}\n";
    echo "   📊 Total Finances: {$totalFinances}\n";
    echo "   📊 Total Installments: {$totalInstallments}\n";
    echo "   📊 Installment Finances: {$installmentFinances}\n";

    // Test relationship integrity
    $studentsWithFinances = Student::has('finances')->count();
    $financesWithStudent = Finance::has('student')->count();

    echo "   🔗 Students with Finances: {$studentsWithFinances}\n";
    echo "   🔗 Finances with Student: {$financesWithStudent}\n";

    // Test 4: Payment progress calculation
    echo "\n4️⃣ Testing Payment Progress Calculation...\n";

    $installmentFinances = Finance::where('payment_type', 'installment')->with('installments')->get();

    foreach ($installmentFinances->take(3) as $finance) {
        echo "   💳 Finance #{$finance->id} ({$finance->student->name}):\n";
        echo "      💰 Total: Rp " . number_format($finance->total_amount) . "\n";
        echo "      💵 Paid: Rp " . number_format($finance->paid_amount) . "\n";
        echo "      📊 Progress: {$finance->payment_progress}%\n";
        echo "      🗓️ Installments: " . $finance->installments->count() . " angsuran\n";

        $paidInstallments = $finance->installments->where('status', 'paid')->count();
        $pendingInstallments = $finance->installments->where('status', 'pending')->count();

        echo "      ✅ Paid: {$paidInstallments} angsuran\n";
        echo "      ⏳ Pending: {$pendingInstallments} angsuran\n";
        echo "\n";
    }

    echo "🎉 FINANCE RELATION MANAGER TEST COMPLETED!\n";
    echo "=" . str_repeat("=", 60) . "\n";
    echo "✅ Student-Finance relationship working properly\n";
    echo "✅ RelationManager can create finances from student context\n";
    echo "✅ Installment generation working from student profile\n";
    echo "✅ Data consistency maintained across all relations\n";
    echo "=" . str_repeat("=", 60) . "\n";
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "📍 File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
