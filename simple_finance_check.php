<?php

// Simple test without Laravel bootstrap
echo "=== Finance Resource File Check ===\n\n";

$financeResourcePath = __DIR__ . '/app/Filament/Resources/FinanceResource.php';
$financeModelPath = __DIR__ . '/app/Models/Finance.php';

// Check if files exist
echo "1. Checking file existence...\n";
echo "   - FinanceResource.php: " . (file_exists($financeResourcePath) ? "✅ EXISTS" : "❌ NOT FOUND") . "\n";
echo "   - Finance.php model: " . (file_exists($financeModelPath) ? "✅ EXISTS" : "❌ NOT FOUND") . "\n";

// Check page files
echo "\n2. Checking page files...\n";
$pageFiles = [
    'ListFinances.php' => __DIR__ . '/app/Filament/Resources/FinanceResource/Pages/ListFinances.php',
    'CreateFinance.php' => __DIR__ . '/app/Filament/Resources/FinanceResource/Pages/CreateFinance.php',
    'EditFinance.php' => __DIR__ . '/app/Filament/Resources/FinanceResource/Pages/EditFinance.php',
];

foreach ($pageFiles as $name => $path) {
    echo "   - $name: " . (file_exists($path) ? "✅ EXISTS" : "❌ NOT FOUND") . "\n";
}

// Check syntax
echo "\n3. Checking PHP syntax...\n";
$files = [$financeResourcePath, $financeModelPath] + array_values($pageFiles);

foreach ($files as $file) {
    if (file_exists($file)) {
        $output = [];
        $result = 0;
        exec("php -l \"$file\" 2>&1", $output, $result);
        $filename = basename($file);
        if ($result === 0) {
            echo "   - $filename: ✅ SYNTAX OK\n";
        } else {
            echo "   - $filename: ❌ SYNTAX ERROR\n";
            echo "     " . implode("\n     ", $output) . "\n";
        }
    }
}

echo "\n=== File Check Complete ===\n";
echo "Next step: Access the admin panel at /admin to see if Finance menu appears\n";
