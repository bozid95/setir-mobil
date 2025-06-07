<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\Package;
use App\Models\Student;
use App\Models\Finance;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo "=== DEBUGGING REGISTRATION ISSUE ===\n\n";

// 1. Check if packages exist
echo "1. Checking packages...\n";
try {
    $packages = Package::all();
    echo "Found " . $packages->count() . " packages\n";
    foreach ($packages as $package) {
        echo "  - ID: {$package->id}, Name: {$package->name}, Price: {$package->price}\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// 2. Check database schema
echo "2. Checking database schema...\n";
try {
    $tables = ['students', 'packages', 'finances'];
    foreach ($tables as $table) {
        if (Schema::hasTable($table)) {
            echo "✓ Table '{$table}' exists\n";
            $columns = Schema::getColumnListing($table);
            echo "  Columns: " . implode(', ', $columns) . "\n";
        } else {
            echo "✗ Table '{$table}' does not exist\n";
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// 3. Test student creation
echo "3. Testing student creation...\n";
try {
    $firstPackage = Package::first();
    if (!$firstPackage) {
        echo "ERROR: No packages found!\n";
    } else {
        $testStudent = [
            'name' => 'Test Student',
            'email' => 'test' . time() . '@example.com',
            'phone_number' => '08123456789',
            'address' => 'Test Address',
            'package_id' => $firstPackage->id,
        ];

        echo "Creating student with data:\n";
        print_r($testStudent);

        $student = Student::create($testStudent);
        echo "✓ Student created successfully with ID: {$student->id}\n";
        echo "✓ Unique code: {$student->unique_code}\n";

        // 4. Test finance creation
        echo "\n4. Testing finance creation...\n";

        $hasStatusColumn = Schema::hasColumn('finances', 'status');
        echo "Status column exists: " . ($hasStatusColumn ? 'Yes' : 'No') . "\n";

        $financeData = [
            'student_id' => $student->id,
            'date' => now(),
            'amount' => $firstPackage->price,
            'type' => 'income',
            'description' => 'Package registration fee - ' . $firstPackage->name,
        ];

        if ($hasStatusColumn) {
            $financeData['status'] = 'pending';
        }

        echo "Creating finance with data:\n";
        print_r($financeData);

        $finance = Finance::create($financeData);
        echo "✓ Finance created successfully with ID: {$finance->id}\n";

        // Clean up test data
        $finance->delete();
        $student->delete();
        echo "\n✓ Test data cleaned up\n";
    }
} catch (Exception $e) {
    echo "ERROR during testing: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
