<?php

echo "=== Manual Driving Sessions Structure Fix ===\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // Check current structure
    $stmt = $pdo->query("DESCRIBE driving_sessions");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Current columns: " . implode(', ', $columns) . "\n";

    // Add 'order' column if it doesn't exist
    if (!in_array('order', $columns)) {
        echo "Adding 'order' column...\n";
        $pdo->exec("ALTER TABLE driving_sessions ADD COLUMN `order` INT NOT NULL DEFAULT 0 AFTER instructor_id");
        echo "✅ 'order' column added successfully!\n";
    } else {
        echo "ℹ️ 'order' column already exists.\n";
    }

    // Add 'title' column if it doesn't exist
    if (!in_array('title', $columns)) {
        echo "Adding 'title' column...\n";
        $pdo->exec("ALTER TABLE driving_sessions ADD COLUMN `title` VARCHAR(255) NULL AFTER `order`");
        echo "✅ 'title' column added successfully!\n";
    } else {
        echo "ℹ️ 'title' column already exists.\n";
    }

    // Verify final structure
    echo "\nFinal structure check:\n";
    $stmt = $pdo->query("DESCRIBE driving_sessions");
    $finalColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($finalColumns as $column) {
        echo "- {$column['Field']} ({$column['Type']}) - {$column['Null']} - Default: {$column['Default']}\n";
    }

    echo "\n🎉 Driving sessions table structure fix completed!\n";

    // Mark migration as run
    echo "\nMarking migration as completed in database...\n";
    $migrationName = '2025_06_13_164754_add_missing_columns_to_driving_sessions_table';
    $batch = $pdo->query("SELECT MAX(batch) + 1 as next_batch FROM migrations")->fetch()['next_batch'] ?? 1;

    $stmt = $pdo->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?) ON DUPLICATE KEY UPDATE batch = batch");
    $stmt->execute([$migrationName, $batch]);

    echo "✅ Migration marked as completed!\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}