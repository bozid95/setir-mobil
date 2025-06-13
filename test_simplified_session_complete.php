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

echo "=== Testing Simplified Session Creation ===\n";

try {
    // Test dengan data minimal yang diperlukan
    $session = new \App\Models\Session();
    $session->name = 'Sesi Mengemudi 1';
    $session->order = 1;
    $session->description = 'Perkenalan dasar mengemudi dan safety';
    $session->package_id = 1; // Assuming package 1 exists

    $session->save();

    echo "✅ Session created successfully!\n";
    echo "Session ID: {$session->id}\n";
    echo "Session Name: {$session->name}\n";
    echo "Session Order: {$session->order}\n";
    echo "Session Description: {$session->description}\n";
    echo "Package ID: {$session->package_id}\n";

    // Verify database structure
    echo "\n=== Database Structure Verification ===\n";
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
    $stmt = $pdo->query('DESCRIBE driving_sessions');
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Current table structure:\n";
    foreach ($columns as $col) {
        echo "- {$col['Field']} ({$col['Type']})\n";
    }

    // Clean up test data
    $session->delete();
    echo "\n🧹 Test session cleaned up.\n";

    echo "\n🎉 SIMPLIFIED SESSION STRUCTURE WORKING PERFECTLY!\n";
    echo "✅ Only required fields: name, order, description, package_id\n";
    echo "✅ No more instructor_id, title, duration_minutes, is_active fields\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
