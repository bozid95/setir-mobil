<?php
// Simple script to remove email unique constraint
echo "Removing email unique constraint...\n";

try {
    // Connect to database
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=rental_mobil', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if constraint exists
    $stmt = $pdo->query("SHOW INDEX FROM students WHERE Key_name = 'students_email_unique'");
    $constraints = $stmt->fetchAll();

    if (count($constraints) > 0) {
        echo "Found unique constraint, removing...\n";
        $pdo->exec("ALTER TABLE students DROP INDEX students_email_unique");
        echo "✓ Successfully removed unique constraint from email column\n";
    } else {
        echo "No unique constraint found on email column\n";
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";

    // Try alternative method
    echo "Trying alternative approach...\n";
    try {
        $pdo->exec("ALTER TABLE students DROP KEY students_email_unique");
        echo "✓ Successfully removed constraint using alternative method\n";
    } catch (Exception $e2) {
        echo "Alternative method also failed: " . $e2->getMessage() . "\n";
    }
}

echo "Done.\n";
