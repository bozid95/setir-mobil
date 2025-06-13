<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING DRIVING_SESSIONS TABLE STRUCTURE ===\n\n";

try {
    // Get table columns
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('driving_sessions');
    
    echo "Current columns in driving_sessions table:\n";
    foreach ($columns as $column) {
        echo "  - $column\n";
    }
    
    echo "\nColumns expected by Session model/resources:\n";
    $expectedColumns = [
        'id', 'package_id', 'instructor_id', 'order', 'title', 'description', 
        'duration_minutes', 'is_active', 'created_at', 'updated_at'
    ];
    
    foreach ($expectedColumns as $expected) {
        $exists = in_array($expected, $columns);
        echo ($exists ? "✅" : "❌") . " $expected\n";
    }
    
    // Check if 'name' column exists (from original migration)
    echo "\nAnalysis:\n";
    if (in_array('name', $columns) && !in_array('title', $columns)) {
        echo "📝 Found 'name' column but missing 'title' - need to add 'title' or rename 'name'\n";
    }
    
    if (!in_array('order', $columns)) {
        echo "📝 Missing 'order' column - needed for session ordering\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n=== RECOMMENDATION ===\n";
echo "Run migration to add missing columns, then update Session model if needed.\n";
