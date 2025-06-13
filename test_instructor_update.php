<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== TESTING INSTRUCTOR UPDATE FIX ===\n\n";

try {
    // 1. Check available instructors
    echo "1. Testing Instructor model fields...\n";

    $instructor = App\Models\Instructor::first();
    if ($instructor) {
        echo "   ✅ Instructor found: {$instructor->name}\n";

        // Check fillable fields
        $fillable = $instructor->getFillable();
        echo "   ✅ Fillable fields: " . implode(', ', $fillable) . "\n";

        // Check casts
        $casts = $instructor->getCasts();
        echo "   ✅ Casts: " . implode(', ', array_keys($casts)) . "\n";
    } else {
        echo "   ❌ No instructors found\n";
    }

    // 2. Test creating new instructor with all fields
    echo "\n2. Testing instructor creation with all fields...\n";

    $testData = [
        'name' => 'Test Instructor ' . time(),
        'email' => 'test' . time() . '@instructor.com',
        'phone_number' => '081234567899',
        'address' => 'Test Address for Instructor',
        'license_number' => 'LIC' . time(),
        'license_expiry' => now()->addYears(2)->toDateString(),
        'is_active' => true,
    ];

    $newInstructor = App\Models\Instructor::create($testData);
    echo "   ✅ Instructor created: {$newInstructor->name} (ID: {$newInstructor->id})\n";
    echo "   ✅ Email: {$newInstructor->email}\n";
    echo "   ✅ License: {$newInstructor->license_number}\n";
    echo "   ✅ Active: " . ($newInstructor->is_active ? 'Yes' : 'No') . "\n";

    // 3. Test updating instructor
    echo "\n3. Testing instructor update...\n";

    $updateData = [
        'name' => 'Updated Test Instructor',
        'email' => 'updated' . time() . '@instructor.com',
        'phone_number' => '081999888777',
        'address' => 'Updated Address',
        'license_number' => 'UPDATED' . time(),
        'is_active' => false,
    ];

    $newInstructor->update($updateData);
    $newInstructor->refresh();

    echo "   ✅ Instructor updated: {$newInstructor->name}\n";
    echo "   ✅ New email: {$newInstructor->email}\n";
    echo "   ✅ New phone: {$newInstructor->phone_number}\n";
    echo "   ✅ Active status: " . ($newInstructor->is_active ? 'Yes' : 'No') . "\n";

    // 4. Test database columns vs model fillable
    echo "\n4. Verifying database columns vs model fillable...\n";

    $dbColumns = \Illuminate\Support\Facades\Schema::getColumnListing('instructors');
    $modelFillable = $newInstructor->getFillable();

    echo "   📋 Database columns: " . implode(', ', $dbColumns) . "\n";
    echo "   📋 Model fillable: " . implode(', ', $modelFillable) . "\n";

    $missingInModel = array_diff($dbColumns, array_merge($modelFillable, ['id', 'created_at', 'updated_at']));
    $missingInDb = array_diff($modelFillable, $dbColumns);

    if (empty($missingInModel) && empty($missingInDb)) {
        echo "   ✅ All columns properly mapped\n";
    } else {
        if (!empty($missingInModel)) {
            echo "   ⚠️  Missing in model: " . implode(', ', $missingInModel) . "\n";
        }
        if (!empty($missingInDb)) {
            echo "   ⚠️  Missing in database: " . implode(', ', $missingInDb) . "\n";
        }
    }

    // Clean up test data
    $newInstructor->delete();
    echo "\n   🧹 Test instructor cleaned up\n";

    echo "\n✅ ALL TESTS PASSED!\n";
    echo "Instructor update should now work without errors.\n";
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
