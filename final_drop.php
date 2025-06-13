<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
try {
    $pdo->exec('ALTER TABLE driving_sessions DROP COLUMN instructor_id');
    echo "instructor_id column dropped successfully!\n";
} catch (Exception $e) {
    echo "Error or column already dropped: " . $e->getMessage() . "\n";
}

// Verify final structure
$stmt = $pdo->query('DESCRIBE driving_sessions');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "\nFinal structure:\n";
foreach ($columns as $col) {
    echo "- {$col['Field']} ({$col['Type']})\n";
}
