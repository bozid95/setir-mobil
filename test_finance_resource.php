<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Filament\Resources\FinanceResource;
use App\Models\Finance;

echo "=== Finance Resource Verification ===\n\n";

// Test 1: Check if FinanceResource class exists
echo "1. Checking FinanceResource class... ";
if (class_exists(FinanceResource::class)) {
    echo "✅ EXISTS\n";
} else {
    echo "❌ NOT FOUND\n";
}

// Test 2: Check Finance model
echo "2. Checking Finance model... ";
if (class_exists(Finance::class)) {
    echo "✅ EXISTS\n";
} else {
    echo "❌ NOT FOUND\n";
}

// Test 3: Check if resource methods are accessible
echo "3. Checking resource configuration...\n";
try {
    $model = FinanceResource::getModel();
    echo "   - Model: " . $model . " ✅\n";

    $navigationGroup = FinanceResource::getNavigationGroup();
    echo "   - Navigation Group: " . ($navigationGroup ?? 'Default') . " ✅\n";

    $navigationLabel = FinanceResource::getNavigationLabel();
    echo "   - Navigation Label: " . $navigationLabel . " ✅\n";

    $navigationIcon = FinanceResource::getNavigationIcon();
    echo "   - Navigation Icon: " . ($navigationIcon ?? 'Default') . " ✅\n";
} catch (Exception $e) {
    echo "   ❌ Error: " . $e->getMessage() . "\n";
}

// Test 4: Check page files
echo "4. Checking page files...\n";
$pageFiles = [
    'ListFinances' => 'App\\Filament\\Resources\\FinanceResource\\Pages\\ListFinances',
    'CreateFinance' => 'App\\Filament\\Resources\\FinanceResource\\Pages\\CreateFinance',
    'EditFinance' => 'App\\Filament\\Resources\\FinanceResource\\Pages\\EditFinance',
];

foreach ($pageFiles as $name => $class) {
    echo "   - $name: ";
    if (class_exists($class)) {
        echo "✅ EXISTS\n";
    } else {
        echo "❌ NOT FOUND\n";
    }
}

echo "\n=== Verification Complete ===\n";
echo "If all checks show ✅, the Finance menu should appear in Filament admin panel.\n";
echo "Make sure to:\n";
echo "1. Clear caches: php artisan config:clear && php artisan cache:clear\n";
echo "2. Access the admin panel at /admin\n";
echo "3. Look for 'Finance' in the navigation menu\n";
