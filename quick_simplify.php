<?php

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "=== Current Driving Sessions Structure ===\n";
$stmt = $pdo->query("DESCRIBE driving_sessions");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($columns as $column) {
    echo "{$column['Field']} - {$column['Type']} - {$column['Null']} - {$column['Default']}\n";
}

echo "\n=== Simplifying Table ===\n";

// Drop unnecessary columns
$columnsToRemove = ['instructor_id', 'title', 'duration_minutes', 'is_active'];

foreach ($columnsToRemove as $col) {
    try {
        $pdo->exec("ALTER TABLE driving_sessions DROP COLUMN `{$col}`");
        echo "✅ Dropped {$col}\n";
    } catch (Exception $e) {
        echo "ℹ️ {$col} already removed or doesn't exist\n";
    }
}

echo "\n=== Final Structure ===\n";
$stmt = $pdo->query("DESCRIBE driving_sessions");
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($columns as $column) {
    echo "{$column['Field']} - {$column['Type']}\n";
}

echo "\n✅ Table simplified! Only keeping: name, order, description, package_id\n";
