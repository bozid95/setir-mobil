<?php

use Illuminate\Support\Facades\Log;

try {
    echo "=== Comprehensive FinanceResource Test ===\n\n";

    // Step 1: Test basic file operations
    echo "1. File System Tests:\n";
    $resourcePath = __DIR__ . '/app/Filament/Resources/FinanceResource.php';

    if (!file_exists($resourcePath)) {
        echo "   ❌ FinanceResource.php does not exist\n";
        exit(1);
    }
    echo "   ✅ FinanceResource.php exists\n";

    $content = file_get_contents($resourcePath);
    if (empty($content)) {
        echo "   ❌ FinanceResource.php is empty\n";
        exit(1);
    }
    echo "   ✅ FinanceResource.php has content (" . strlen($content) . " bytes)\n";

    // Step 2: Test PHP syntax
    echo "\n2. PHP Syntax Test:\n";
    $syntaxCheck = shell_exec("php -l \"$resourcePath\" 2>&1");
    if (strpos($syntaxCheck, 'No syntax errors') === false) {
        echo "   ❌ Syntax errors found:\n";
        echo "   " . $syntaxCheck . "\n";
        exit(1);
    }
    echo "   ✅ PHP syntax is valid\n";

    // Step 3: Bootstrap Laravel
    echo "\n3. Laravel Bootstrap:\n";
    require __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    echo "   ✅ Laravel bootstrapped successfully\n";

    // Step 4: Test model dependencies
    echo "\n4. Model Dependencies:\n";
    try {
        $financeModel = new App\Models\Finance();
        echo "   ✅ Finance model instantiated\n";

        $student = new App\Models\Student();
        echo "   ✅ Student model instantiated\n";
    } catch (Exception $e) {
        echo "   ❌ Model error: " . $e->getMessage() . "\n";
        exit(1);
    }

    // Step 5: Test Filament dependencies
    echo "\n5. Filament Dependencies:\n";
    try {
        $form = new Filament\Forms\Form();
        echo "   ✅ Filament Form class available\n";

        $table = new Filament\Tables\Table();
        echo "   ✅ Filament Table class available\n";

        $resource = new Filament\Resources\Resource();
        echo "   ✅ Filament Resource class available\n";
    } catch (Exception $e) {
        echo "   ❌ Filament dependency error: " . $e->getMessage() . "\n";
        exit(1);
    }

    // Step 6: Test direct class inclusion
    echo "\n6. Class Inclusion Test:\n";
    try {
        // Capture any errors during inclusion
        ob_start();
        error_reporting(E_ALL);
        set_error_handler(function ($severity, $message, $file, $line) {
            throw new ErrorException($message, 0, $severity, $file, $line);
        });

        require_once $resourcePath;

        restore_error_handler();
        $errors = ob_get_clean();

        if (!empty($errors)) {
            echo "   ⚠️ Inclusion warnings/notices:\n";
            echo "   " . $errors . "\n";
        } else {
            echo "   ✅ File included without errors\n";
        }

        if (class_exists('App\\Filament\\Resources\\FinanceResource')) {
            echo "   ✅ FinanceResource class found\n";
        } else {
            echo "   ❌ FinanceResource class not found after inclusion\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Inclusion error: " . $e->getMessage() . "\n";
        echo "   File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
    }

    echo "\n=== Test Complete ===\n";
} catch (Exception $e) {
    echo "❌ Fatal error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " Line: " . $e->getLine() . "\n";
}
