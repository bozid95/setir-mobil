<?php

// Simple test to check if FinanceResource can be loaded
echo "Testing FinanceResource loading...\n";

try {
    require_once __DIR__ . '/vendor/autoload.php';

    // Try to load the FinanceResource class
    $resourceFile = __DIR__ . '/app/Filament/Resources/FinanceResource.php';

    if (file_exists($resourceFile)) {
        echo "✅ FinanceResource.php file exists\n";

        // Include the file manually to check for errors
        include_once $resourceFile;
        echo "✅ FinanceResource.php included successfully\n";

        // Check if class exists
        if (class_exists('App\Filament\Resources\FinanceResource')) {
            echo "✅ FinanceResource class loaded\n";
        } else {
            echo "❌ FinanceResource class not found after include\n";
        }
    } else {
        echo "❌ FinanceResource.php file not found\n";
    }
} catch (ParseError $e) {
    echo "❌ Parse Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} catch (Error $e) {
    echo "❌ Fatal Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
