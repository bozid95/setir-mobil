<?php

$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
$stmt = $pdo->query('DESCRIBE driving_sessions');
$columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "=== Driving Sessions Table Structure ===\n";
foreach ($columns as $column) {
    $required = ($column['Null'] === 'NO' && $column['Default'] === null) ? " [REQUIRED]" : "";
    echo $column['Field'] . ' - Type: ' . $column['Type'] . ' - Null: ' . $column['Null'] . ' - Default: ' . ($column['Default'] ?: 'NULL') . $required . "\n";
}
