<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=rental-mobil', 'root', '');

echo "=== Removing Foreign Key Constraints ===\n";

try {
    // First, let's see what foreign keys exist
    $stmt = $pdo->query("
        SELECT CONSTRAINT_NAME
        FROM information_schema.KEY_COLUMN_USAGE
        WHERE TABLE_NAME = 'driving_sessions'
        AND CONSTRAINT_NAME != 'PRIMARY'
        AND TABLE_SCHEMA = 'rental-mobil'
    ");
    $constraints = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Found constraints: " . implode(', ', $constraints) . "\n";

    // Drop foreign key constraints
    foreach ($constraints as $constraint) {
        try {
            $pdo->exec("ALTER TABLE driving_sessions DROP FOREIGN KEY `{$constraint}`");
            echo "✅ Dropped constraint: {$constraint}\n";
        } catch (Exception $e) {
            echo "ℹ️ Could not drop {$constraint}: " . $e->getMessage() . "\n";
        }
    }

    // Now try to drop the instructor_id column
    echo "\n=== Dropping instructor_id column ===\n";
    $pdo->exec('ALTER TABLE driving_sessions DROP COLUMN instructor_id');
    echo "✅ instructor_id column dropped successfully!\n";

    // Verify final structure
    echo "\n=== Final Structure ===\n";
    $stmt = $pdo->query('DESCRIBE driving_sessions');
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($columns as $col) {
        echo "- {$col['Field']} ({$col['Type']})\n";
    }

    echo "\n🎉 Table simplified successfully!\n";
    echo "Now contains only: name, order, description, package_id + timestamps\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
