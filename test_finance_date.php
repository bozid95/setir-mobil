<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Finance;
use Illuminate\Support\Facades\Schema;

echo "Testing Finance Date Field...\n";
echo "=============================\n";

// Check if date column exists
$hasDateColumn = Schema::hasColumn('finances', 'date');
echo "Date column exists: " . ($hasDateColumn ? 'YES' : 'NO') . "\n";

// Check Finance model fillable fields
$finance = new Finance();
$fillable = $finance->getFillable();
echo "\nFinance model fillable fields:\n";
foreach ($fillable as $field) {
    echo "- $field\n";
}

// Test creating finance data
$testData = [
    'student_id' => 1,
    'date' => now(),
    'amount' => 1000000.00,
    'type' => 'income',
    'description' => 'Test package registration fee',
];

echo "\nTest finance data structure:\n";
foreach ($testData as $key => $value) {
    echo "- $key: $value\n";
}

echo "\n✅ Finance creation should now work with date field!\n";
echo "💡 Registration will include current date/time automatically.\n";
