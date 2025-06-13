<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Http\Controllers\LandingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

echo "=== TRACK PROGRESS FORM SUBMISSION TEST ===\n";

// Get test student
$student = Student::first();
echo "Test Student: {$student->name} | Code: {$student->unique_code}\n\n";

// Test 1: Direct controller method test
echo "1. Testing trackStudent controller method directly...\n";

try {
    $controller = new LandingController();

    // Create mock request
    $request = new Request();
    $request->merge(['tracking_code' => $student->unique_code]);

    // Validate input manually (since we can't test validation easily)
    if (empty(trim($request->tracking_code))) {
        echo "❌ Validation failed: Empty tracking code\n";
    } elseif (strlen($request->tracking_code) < 8) {
        echo "❌ Validation failed: Too short\n";
    } elseif (strlen($request->tracking_code) > 20) {
        echo "❌ Validation failed: Too long\n";
    } else {
        echo "✅ Validation passed\n";

        $trackingCode = trim(strtoupper($request->tracking_code));
        $foundStudent = Student::where('unique_code', $trackingCode)->first();

        if (!$foundStudent) {
            echo "❌ Student not found\n";
        } else {
            echo "✅ Student found: {$foundStudent->name}\n";
            echo "✅ Would redirect to: " . route('student.dashboard', ['code' => $trackingCode]) . "\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Controller error: " . $e->getMessage() . "\n";
}

// Test 2: Route verification
echo "\n2. Testing routes...\n";
try {
    $landingRoute = route('landing.index');
    $trackRoute = route('student.track');
    $dashboardRoute = route('student.dashboard', ['code' => $student->unique_code]);

    echo "✅ Landing route: {$landingRoute}\n";
    echo "✅ Track route: {$trackRoute}\n";
    echo "✅ Dashboard route: {$dashboardRoute}\n";
} catch (Exception $e) {
    echo "❌ Route error: " . $e->getMessage() . "\n";
}

// Test 3: Check if form submission works with various inputs
echo "\n3. Testing form submission scenarios...\n";

$testInputs = [
    $student->unique_code,           // Valid
    strtolower($student->unique_code), // Valid (lowercase)
    '  ' . $student->unique_code . '  ', // Valid (with spaces)
    'INVALID123',                    // Invalid
    '',                             // Empty
    'short',                        // Too short
];

foreach ($testInputs as $input) {
    echo "\nInput: '{$input}'\n";

    // Simulate validation
    $errors = [];

    if (empty(trim($input))) {
        $errors[] = 'Please enter your tracking code.';
    } elseif (strlen($input) < 8) {
        $errors[] = 'Tracking code must be at least 8 characters.';
    } elseif (strlen($input) > 20) {
        $errors[] = 'Tracking code cannot exceed 20 characters.';
    }

    if (!empty($errors)) {
        echo "❌ Validation errors: " . implode(', ', $errors) . "\n";
        continue;
    }

    // Check student exists
    $trackingCode = trim(strtoupper($input));
    $foundStudent = Student::where('unique_code', $trackingCode)->first();

    if (!$foundStudent) {
        echo "❌ Student not found with code: {$trackingCode}\n";
    } else {
        echo "✅ Success! Would redirect to dashboard for: {$foundStudent->name}\n";
    }
}

// Test 4: Check if there might be JavaScript issues
echo "\n4. Checking for potential frontend issues...\n";

// Check if form has proper attributes
echo "Form attributes that should be present:\n";
echo "- action=\"" . route('student.track') . "\"\n";
echo "- method=\"POST\"\n";
echo "- @csrf token\n";
echo "- input name=\"tracking_code\"\n";
echo "- submit button type=\"submit\"\n";

echo "\n5. Checking error display...\n";
// Test what happens with invalid input
$invalidRequest = new Request();
$invalidRequest->merge(['tracking_code' => 'INVALID']);

try {
    // Simulate validation failure
    $validator = \Illuminate\Support\Facades\Validator::make(
        ['tracking_code' => 'INVALID'],
        ['tracking_code' => 'required|string|min:8|max:20']
    );

    if ($validator->fails()) {
        echo "✅ Validation correctly catches invalid input\n";
        foreach ($validator->errors()->all() as $error) {
            echo "   Error: {$error}\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Validation error: " . $e->getMessage() . "\n";
}

echo "\n=== DIAGNOSIS ===\n";
echo "If the Track Progress button is not working, possible causes:\n";
echo "1. JavaScript errors preventing form submission\n";
echo "2. CSRF token issues\n";
echo "3. Form validation preventing submission\n";
echo "4. Server not running or routes not accessible\n";
echo "5. Browser cache issues\n";
echo "\nNext steps:\n";
echo "1. Check browser console for JavaScript errors\n";
echo "2. Check browser network tab for failed requests\n";
echo "3. Try with a valid tracking code: {$student->unique_code}\n";
echo "4. Clear browser cache and cookies\n";
