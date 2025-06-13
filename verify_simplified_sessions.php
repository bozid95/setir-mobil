<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
$stmt = $pdo->query('DESCRIBE driving_sessions');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "=== Final driving_sessions structure ===\n";
foreach ($columns as $col) {
    echo "- {$col['Field']} ({$col['Type']})\n";
}

echo "\n=== Testing session creation ===\n";
try {
    $testData = [
        'name' => 'Test Session Sederhana',
        'order' => 1,
        'description' => 'Deskripsi sesi test',
        'package_id' => 1
    ];

    $stmt = $pdo->prepare("INSERT INTO driving_sessions (name, `order`, description, package_id, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
    $stmt->execute([$testData['name'], $testData['order'], $testData['description'], $testData['package_id']]);

    $sessionId = $pdo->lastInsertId();
    echo "✅ Session created successfully with ID: {$sessionId}\n";

    // Clean up test data
    $pdo->exec("DELETE FROM driving_sessions WHERE id = {$sessionId}");
    echo "🧹 Test data cleaned up\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
