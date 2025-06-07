<?php

// Simple database check script
try {
    // Set up basic Laravel environment
    require_once __DIR__ . '/vendor/autoload.php';

    $app = require_once __DIR__ . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    echo "=== DATABASE STATUS CHECK ===\n\n";

    // Check database connection
    echo "1. Testing database connection...\n";
    try {
        DB::connection()->getPdo();
        echo "✓ Database connection successful\n";
    } catch (Exception $e) {
        echo "✗ Database connection failed: " . $e->getMessage() . "\n";
        exit(1);
    }

    // Check if tables exist
    echo "\n2. Checking required tables...\n";
    $requiredTables = ['packages', 'students', 'finances'];

    foreach ($requiredTables as $table) {
        if (Schema::hasTable($table)) {
            echo "✓ Table '{$table}' exists\n";

            // Check table structure
            $columns = Schema::getColumnListing($table);
            echo "  Columns: " . implode(', ', $columns) . "\n";

            // Count records
            $count = DB::table($table)->count();
            echo "  Records: {$count}\n";
        } else {
            echo "✗ Table '{$table}' missing\n";
        }
    }

    // Check if packages exist
    echo "\n3. Checking packages data...\n";
    try {
        $packages = App\Models\Package::all();
        if ($packages->count() > 0) {
            echo "✓ Found {$packages->count()} packages:\n";
            foreach ($packages as $package) {
                echo "  - {$package->name} (ID: {$package->id}, Price: Rp " . number_format($package->price) . ")\n";
            }
        } else {
            echo "⚠ No packages found in database\n";
            echo "You may need to seed the database with package data.\n";
        }
    } catch (Exception $e) {
        echo "✗ Error accessing packages: " . $e->getMessage() . "\n";
    }

    // Test student creation
    echo "\n4. Testing student model...\n";
    try {
        $testData = [
            'name' => 'Test Student ' . time(),
            'package_id' => 1, // Assuming package ID 1 exists
        ];

        // Check if Student model can be instantiated
        $student = new App\Models\Student($testData);
        echo "✓ Student model can be instantiated\n";

        // Check fillable fields
        $fillable = $student->getFillable();
        echo "  Fillable fields: " . implode(', ', $fillable) . "\n";
    } catch (Exception $e) {
        echo "✗ Error with Student model: " . $e->getMessage() . "\n";
    }

    echo "\n=== CHECK COMPLETE ===\n";
} catch (Exception $e) {
    echo "FATAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
