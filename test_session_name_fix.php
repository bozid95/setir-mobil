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

echo "=== Testing Session Creation with Required 'name' Field ===\n";

try {
    // Test creating a session with all required fields including 'name'
    $session = new \App\Models\Session();
    $session->name = 'Driving Session Test';  // Now providing the required name field
    $session->title = 'Pertemuan 1';
    $session->description = 'Basic driving skills introduction';
    $session->package_id = 1; // Assuming package ID 1 exists
    $session->instructor_id = 1; // Assuming instructor ID 1 exists
    $session->order = 1;
    $session->duration_minutes = 60;
    $session->is_active = true;

    $session->save();

    echo "✅ Session created successfully with name field!\n";
    echo "Session ID: {$session->id}\n";
    echo "Session Name: {$session->name}\n";
    echo "Session Title: {$session->title}\n";
    echo "Session Order: {$session->order}\n";

    // Clean up - delete the test session
    $session->delete();
    echo "🧹 Test session cleaned up.\n";
} catch (Exception $e) {
    echo "❌ Error creating session: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Session Model Fillable Fields ===\n";
$sessionModel = new \App\Models\Session();
$fillableFields = $sessionModel->getFillable();
echo "Fillable fields: " . implode(', ', $fillableFields) . "\n";

// Check if 'name' is in fillable
if (in_array('name', $fillableFields)) {
    echo "✅ 'name' field is properly configured in fillable array\n";
} else {
    echo "❌ 'name' field is missing from fillable array\n";
}

echo "\n=== Database Structure Verification ===\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
    $stmt = $pdo->query("DESCRIBE driving_sessions");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Required fields in driving_sessions table:\n";
    foreach ($columns as $column) {
        if ($column['Null'] === 'NO' && $column['Default'] === null) {
            echo "- {$column['Field']} ({$column['Type']}) [REQUIRED]\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Error checking database structure: " . $e->getMessage() . "\n";
}
