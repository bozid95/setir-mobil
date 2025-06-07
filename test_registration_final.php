<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

use App\Models\Student;
use App\Models\Package;
use App\Models\Finance;

echo "=== TESTING REGISTRATION ===\n\n";

try {
    // Test dengan email yang sama untuk memastikan tidak ada unique constraint
    $testData = [
        'name' => 'Test Student ' . time(),
        'email' => 'redodo@gmail.com', // Email yang sama yang gagal sebelumnya
        'phone_number' => '08123456789',
        'address' => 'Test Address',
        'package_id' => 1, // Assuming package 1 exists
    ];

    echo "Creating student with data:\n";
    foreach ($testData as $key => $value) {
        echo "  {$key}: {$value}\n";
    }

    $student = Student::create($testData);
    echo "\n✓ Student created successfully!\n";
    echo "  ID: {$student->id}\n";
    echo "  Unique Code: {$student->unique_code}\n";
    echo "  Email: {$student->email}\n";

    // Test finance creation
    $package = Package::find($testData['package_id']);
    if ($package) {
        $financeData = [
            'student_id' => $student->id,
            'date' => now(),
            'amount' => $package->price,
            'type' => 'income',
            'description' => 'Package registration fee - ' . $package->name,
            'status' => 'pending',
        ];

        $finance = Finance::create($financeData);
        echo "✓ Finance record created successfully!\n";
        echo "  ID: {$finance->id}\n";
        echo "  Amount: Rp " . number_format($finance->amount) . "\n";
    }

    echo "\n=== REGISTRATION TEST SUCCESSFUL ===\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
