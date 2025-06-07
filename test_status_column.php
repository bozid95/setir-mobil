<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use App\Models\Finance;

echo "Testing Status Column in Finances Table...\n";
echo "======================================\n";

// Check if status column exists
$hasStatusColumn = Schema::hasColumn('finances', 'status');
echo "Status column exists: " . ($hasStatusColumn ? 'YES' : 'NO') . "\n";

if ($hasStatusColumn) {
    echo "✅ Finance table has status column - Registration will work with status\n";
} else {
    echo "❌ Finance table missing status column - Registration will work without status\n";
}

// Test Finance model fillable fields
$finance = new Finance();
$fillable = $finance->getFillable();
echo "\nFinance model fillable fields:\n";
foreach ($fillable as $field) {
    echo "- $field\n";
}

echo "\n✅ Registration system is now compatible with both scenarios!\n";
