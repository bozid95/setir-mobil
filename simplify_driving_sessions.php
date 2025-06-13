<?php

echo "=== Simplifying Driving Sessions Table ===\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to database successfully.\n";

    // Check current structure
    echo "\nCurrent table structure:\n";
    $stmt = $pdo->query("DESCRIBE driving_sessions");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $column) {
        echo "- {$column['Field']} ({$column['Type']})\n";
    }

    // Remove unnecessary columns
    $columnsToRemove = ['instructor_id', 'title', 'duration_minutes', 'is_active'];

    foreach ($columnsToRemove as $columnName) {
        // Check if column exists before dropping
        $columnExists = false;
        foreach ($columns as $column) {
            if ($column['Field'] === $columnName) {
                $columnExists = true;
                break;
            }
        }

        if ($columnExists) {
            echo "\nDropping column: {$columnName}...\n";
            $pdo->exec("ALTER TABLE driving_sessions DROP COLUMN `{$columnName}`");
            echo "✅ Column '{$columnName}' dropped successfully!\n";
        } else {
            echo "ℹ️ Column '{$columnName}' doesn't exist, skipping.\n";
        }
    }

    // Show final structure
    echo "\nFinal simplified table structure:\n";
    $stmt = $pdo->query("DESCRIBE driving_sessions");
    $finalColumns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($finalColumns as $column) {
        echo "- {$column['Field']} ({$column['Type']}) - Null: {$column['Null']} - Default: " . ($column['Default'] ?: 'NULL') . "\n";
    }

    echo "\n🎉 Driving sessions table simplified successfully!\n";
    echo "\nRemaining fields:\n";
    echo "- name: Session name (required)\n";
    echo "- order: Session order/sequence\n";
    echo "- description: Session description\n";
    echo "- package_id: Link to package\n";
    echo "- timestamps: created_at, updated_at\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
