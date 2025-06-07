<?php
echo "Checking database tables...\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=rental-mobil', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Show all tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);

    echo "Existing tables:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }

    // Check if students table exists and its structure
    if (in_array('students', $tables)) {
        echo "\nStudents table structure:\n";
        $stmt = $pdo->query("DESCRIBE students");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($columns as $column) {
            echo "- {$column['Field']}: {$column['Type']} {$column['Key']}\n";
        }

        // Check indexes
        echo "\nStudents table indexes:\n";
        $stmt = $pdo->query("SHOW INDEX FROM students");
        $indexes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($indexes as $index) {
            echo "- {$index['Key_name']}: {$index['Column_name']}\n";
        }
    } else {
        echo "\nStudents table does not exist.\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
