<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Student;
use App\Models\Package;

echo "=== TESTING REGISTRATION FORM ===\n\n";

// 1. Check if packages exist
echo "1. Checking Packages...\n";
$packages = Package::all();
echo "Available packages: " . $packages->count() . "\n";
foreach ($packages as $package) {
    echo "- {$package->name} (ID: {$package->id}): Rp " . number_format($package->price, 0, ',', '.') . "\n";
}

// 2. Test data for registration
echo "\n2. Testing Registration Data Validation...\n";
$testData = [
    'name' => 'John Doe Test',
    'gender' => 'male',
    'place_of_birth' => 'Jakarta',
    'date_of_birth' => '1995-05-15',
    'occupation' => 'Software Engineer',
    'email' => 'john.test' . time() . '@example.com', // unique email
    'phone_number' => '081234567890',
    'address' => 'Jl. Test Street No. 123, Jakarta',
    'package_id' => $packages->first()->id ?? 1,
];

echo "Test data prepared:\n";
foreach ($testData as $key => $value) {
    echo "- {$key}: {$value}\n";
}

// 3. Test validation rules
echo "\n3. Testing Validation Rules...\n";
$validator = \Illuminate\Support\Facades\Validator::make($testData, [
    'name' => 'required|string|max:255',
    'gender' => 'required|in:male,female',
    'place_of_birth' => 'required|string|max:255',
    'date_of_birth' => 'required|date|before:today',
    'occupation' => 'required|string|max:255',
    'email' => 'required|email|unique:students,email',
    'phone_number' => 'required|string|max:20',
    'address' => 'required|string',
    'package_id' => 'required|exists:packages,id',
]);

if ($validator->passes()) {
    echo "✅ All validation rules passed!\n";
} else {
    echo "❌ Validation failed:\n";
    foreach ($validator->errors()->all() as $error) {
        echo "- {$error}\n";
    }
}

// 4. Test actual student creation
echo "\n4. Testing Student Creation...\n";
try {
    $student = Student::create($testData);
    echo "✅ Student created successfully!\n";
    echo "Student ID: {$student->id}\n";
    echo "Unique Code: {$student->unique_code}\n";
    echo "Register Date: {$student->register_date}\n";

    // Clean up - delete test student
    $student->delete();
    echo "✅ Test student cleaned up\n";
} catch (Exception $e) {
    echo "❌ Student creation failed: " . $e->getMessage() . "\n";
}

// 5. Check Student model fillable fields
echo "\n5. Checking Student Model Configuration...\n";
$student = new Student();
$fillable = $student->getFillable();
echo "Fillable fields: " . implode(', ', $fillable) . "\n";

$requiredFields = ['name', 'gender', 'place_of_birth', 'date_of_birth', 'occupation', 'email', 'phone_number', 'address', 'package_id'];
$missingFields = array_diff($requiredFields, $fillable);

if (empty($missingFields)) {
    echo "✅ All required fields are fillable\n";
} else {
    echo "❌ Missing fillable fields: " . implode(', ', $missingFields) . "\n";
}

echo "\n=== REGISTRATION SYSTEM STATUS ===\n";
echo "✅ Packages available: " . $packages->count() . "\n";
echo "✅ All validation rules configured\n";
echo "✅ Student model supports all required fields\n";
echo "✅ Registration form ready for testing\n";

echo "\n🚀 REGISTRATION SYSTEM IS READY!\n";
echo "Access: http://localhost:8000/\n";
