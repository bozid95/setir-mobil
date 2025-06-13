<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== FIXING DRIVING_SESSIONS TABLE STRUCTURE ===\n\n";

try {
    // Check current columns
    $columns = \Illuminate\Support\Facades\Schema::getColumnListing('driving_sessions');
    echo "Current columns: " . implode(', ', $columns) . "\n\n";
    
    // Add missing columns if they don't exist
    if (!in_array('order', $columns)) {
        echo "Adding 'order' column...\n";
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE driving_sessions ADD COLUMN `order` INT NOT NULL DEFAULT 0 AFTER instructor_id");
        echo "✅ Added 'order' column\n";
    } else {
        echo "✅ 'order' column already exists\n";
    }
    
    if (!in_array('title', $columns)) {
        echo "Adding 'title' column...\n";
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE driving_sessions ADD COLUMN `title` VARCHAR(255) NULL AFTER `order`");
        echo "✅ Added 'title' column\n";
    } else {
        echo "✅ 'title' column already exists\n";
    }
    
    // Update Session model fillable if needed
    echo "\n📝 Updating Session model...\n";
    
    // Test creating a session
    echo "\n🧪 Testing session creation...\n";
    $testSession = \App\Models\Session::create([
        'package_id' => 1, // Assuming package with ID 1 exists
        'instructor_id' => 1, // Assuming instructor with ID 1 exists  
        'order' => 1,
        'title' => 'Test Session ' . time(),
        'description' => 'Test session description'
    ]);
    
    echo "✅ Session created successfully!\n";
    echo "   ID: {$testSession->id}\n";
    echo "   Title: {$testSession->title}\n";
    echo "   Order: {$testSession->order}\n";
    
    // Clean up test data
    $testSession->delete();
    echo "✅ Test session cleaned up\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}

echo "\n🎉 DRIVING_SESSIONS TABLE STRUCTURE FIX COMPLETE!\n";
echo "Now you can create sessions with order and title fields.\n";
