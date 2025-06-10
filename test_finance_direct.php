<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Testing Finance Model and Resource ===\n\n";

try {
    // Test Finance model
    echo "1. Testing Finance model...\n";
    $finance = new App\Models\Finance();
    echo "   ✅ Finance model loaded successfully\n";

    // Test if we can query the model
    $count = App\Models\Finance::count();
    echo "   ✅ Finance records count: $count\n";
} catch (Exception $e) {
    echo "   ❌ Finance model error: " . $e->getMessage() . "\n";
}

try {
    // Test FinanceResource
    echo "\n2. Testing FinanceResource class...\n";

    // Try to include the file directly first to check for syntax errors
    echo "   Checking file syntax...\n";
    $syntaxCheck = shell_exec('php -l app/Filament/Resources/FinanceResource.php 2>&1');
    echo "   Syntax check result: " . trim($syntaxCheck) . "\n";

    echo "   Attempting to include FinanceResource.php...\n";
    require_once __DIR__ . '/app/Filament/Resources/FinanceResource.php';
    echo "   ✅ File included successfully\n";

    $resourceClass = 'App\\Filament\\Resources\\FinanceResource';

    if (class_exists($resourceClass)) {
        echo "   ✅ FinanceResource class exists\n";

        // Test model property
        $model = $resourceClass::getModel();
        echo "   ✅ Model: $model\n";

        // Test navigation properties
        $navGroup = $resourceClass::getNavigationGroup();
        $navLabel = $resourceClass::getNavigationLabel();
        $navIcon = $resourceClass::getNavigationIcon();

        echo "   ✅ Navigation Group: " . ($navGroup ?? 'Default') . "\n";
        echo "   ✅ Navigation Label: $navLabel\n";
        echo "   ✅ Navigation Icon: " . ($navIcon ?? 'Default') . "\n";
    } else {
        echo "   ❌ FinanceResource class not found\n";
    }
} catch (Exception $e) {
    echo "   ❌ FinanceResource error: " . $e->getMessage() . "\n";
    echo "   Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== Test Complete ===\n";
