<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIXING INSTRUCTOR EMAIL CONSTRAINT ===\n\n";

try {
    // Use direct SQL to modify the column
    \Illuminate\Support\Facades\DB::statement("ALTER TABLE instructors MODIFY COLUMN email VARCHAR(255) NULL");
    echo "✅ Successfully made email column nullable in instructors table\n";

    // Test creating instructor with only name
    $testInstructor = \App\Models\Instructor::create([
        'name' => 'Test Instructor ' . time()
    ]);

    echo "✅ Successfully created instructor with only name\n";
    echo "   Name: {$testInstructor->name}\n";
    echo "   Email: " . ($testInstructor->email ?: 'NULL') . "\n";

    // Clean up test data
    $testInstructor->delete();
    echo "✅ Test instructor cleaned up\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🎉 INSTRUCTOR EMAIL FIX COMPLETE!\n";
echo "Now you can create instructors with just a name.\n";
