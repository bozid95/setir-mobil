<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "=== FINANCE TABLE STRUCTURE ===\n";

if (Schema::hasTable('finances')) {
    $columns = Schema::getColumnListing('finances');
    echo "Columns: " . implode(', ', $columns) . "\n";

    // Check if due_date column exists
    if (in_array('due_date', $columns)) {
        echo "✅ due_date column exists\n";
    } else {
        echo "❌ due_date column missing\n";
    }
} else {
    echo "❌ finances table does not exist\n";
}

// Check Finance model fillable
use App\Models\Finance;
$finance = new Finance();
$fillable = $finance->getFillable();
echo "\nFillable fields: " . implode(', ', $fillable) . "\n";

// Test creating finance without due_date
echo "\nTesting finance creation without due_date...\n";
try {
    $testFinance = [
        'student_id' => 1,
        'date' => now(),
        'amount' => 100000,
        'type' => 'test',
        'description' => 'Test finance record',
        'status' => 'pending',
    ];

    echo "Data to create: " . json_encode($testFinance) . "\n";

    // Don't actually create, just validate
    $validator = \Illuminate\Support\Facades\Validator::make($testFinance, [
        'student_id' => 'required',
        'amount' => 'required',
        'type' => 'required',
        'description' => 'required',
    ]);

    if ($validator->passes()) {
        echo "✅ Validation passed\n";
    } else {
        echo "❌ Validation failed\n";
    }

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
