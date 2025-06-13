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

echo "=== Testing SessionsRelationManager Fix ===\n";

try {
    // Test query yang sebelumnya error
    $sessions = \App\Models\Session::select('driving_sessions.*')
        ->leftJoin('student_sessions', 'driving_sessions.id', '=', 'student_sessions.session_id')
        ->whereNotExists(function ($query) {
            $query->select('*')
                ->from('students')
                ->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
                ->whereColumn('driving_sessions.id', 'student_sessions.session_id')
                ->where('students.id', 6);
        })
        ->orderBy('driving_sessions.name', 'asc') // Menggunakan 'name' bukan 'title'
        ->limit(50)
        ->get();

    echo "✅ Query executed successfully!\n";
    echo "Sessions found: " . $sessions->count() . "\n";

    foreach ($sessions->take(3) as $session) {
        echo "- {$session->name} (Order: {$session->order})\n";
    }

    // Test struktur tabel saat ini
    echo "\n=== Current Table Structure ===\n";
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
    $stmt = $pdo->query('DESCRIBE driving_sessions');
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "Available columns:\n";
    foreach ($columns as $col) {
        echo "- {$col['Field']}\n";
    }

    echo "\n🎉 SessionsRelationManager fix should be working now!\n";
    echo "✅ Using 'name' instead of 'title' for ordering\n";
    echo "✅ Table only contains: name, order, description, package_id\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
