<?php

echo "=== Testing FinanceResource File Inclusion ===\n\n";

$financeResourcePath = __DIR__ . '/app/Filament/Resources/FinanceResource.php';

echo "1. Checking file existence...\n";
if (file_exists($financeResourcePath)) {
    echo "   ✅ File exists at: $financeResourcePath\n";

    echo "\n2. Checking file content...\n";
    $content = file_get_contents($financeResourcePath);
    $lines = explode("\n", $content);
    echo "   ✅ File has " . count($lines) . " lines\n";

    echo "\n3. First few lines:\n";
    for ($i = 0; $i < min(10, count($lines)); $i++) {
        echo "   " . ($i + 1) . ": " . trim($lines[$i]) . "\n";
    }

    echo "\n4. Testing PHP inclusion...\n";
    ob_start();
    $result = include_once $financeResourcePath;
    $output = ob_get_clean();

    if ($result !== false) {
        echo "   ✅ File included successfully\n";

        echo "\n5. Testing class existence...\n";
        if (class_exists('App\\Filament\\Resources\\FinanceResource')) {
            echo "   ✅ FinanceResource class found!\n";
        } else {
            echo "   ❌ FinanceResource class not found after inclusion\n";
        }
    } else {
        echo "   ❌ File inclusion failed\n";
        if ($output) {
            echo "   Error output: $output\n";
        }
    }
} else {
    echo "   ❌ File does not exist\n";
}

echo "\n=== Test Complete ===\n";
