<?php
echo "Checking database...\n";

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=rental-mobil', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "✅ Connected to database\n";

    // Check if student_sessions table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'student_sessions'");
    if ($stmt->rowCount() > 0) {
        echo "✅ student_sessions table exists\n";

        // Get columns
        $stmt = $pdo->query("DESCRIBE student_sessions");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        echo "Columns: " . implode(', ', $columns) . "\n";

        // Check for date columns specifically
        if (in_array('date', $columns)) {
            echo "✅ 'date' column found\n";
        } else {
            echo "❌ 'date' column missing\n";
        }

        if (in_array('scheduled_date', $columns)) {
            echo "✅ 'scheduled_date' column found\n";
        } else {
            echo "❌ 'scheduled_date' column missing\n";
        }
    } else {
        echo "❌ student_sessions table does not exist\n";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
