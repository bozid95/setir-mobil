<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: __DIR__)
    ->withRouting(
        web: __DIR__ . '/routes/web.php',
        commands: __DIR__ . '/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Testing Driving Sessions Creation ===\n";

try {
    // Test creating a driving session
    $session = new \App\Models\Session();
    $session->name = 'Test Driving Session';
    $session->title = 'Basic Driving Skills';
    $session->description = 'Learn basic driving skills and safety';
    $session->package_id = 1; // Assuming package ID 1 exists
    $session->instructor_id = 1; // Assuming instructor ID 1 exists
    $session->order = 1;
    $session->duration_minutes = 60;
    $session->is_active = true;

    $session->save();

    echo "✅ Driving session created successfully!\n";
    echo "Session ID: {$session->id}\n";
    echo "Session Name: {$session->name}\n";
    echo "Session Title: {$session->title}\n";
    echo "Session Order: {$session->order}\n";

    // Clean up - delete the test session
    $session->delete();
    echo "🧹 Test session cleaned up.\n";
} catch (Exception $e) {
    echo "❌ Error creating driving session: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Database Schema Verification ===\n";

// Verify the structure is correct
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
    $stmt = $pdo->query("DESCRIBE driving_sessions");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Table 'driving_sessions' structure:\n";
    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']}) - Null: {$column['Null']} - Default: " . ($column['Default'] ?: 'NULL') . "\n";
    }

    echo "\n✅ All required columns are present!\n";
} catch (Exception $e) {
    echo "❌ Error checking database structure: " . $e->getMessage() . "\n";
}
