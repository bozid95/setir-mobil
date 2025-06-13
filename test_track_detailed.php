<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;

echo "=== TRACK PROGRESS DETAILED TEST ===\n";

// Get test student
$student = Student::first();
echo "Test with student: {$student->name} | Code: {$student->unique_code}\n\n";

// Test current Track Progress logic
echo "=== Testing Current Controller Logic ===\n";

function testTrackProgress($inputCode)
{
    echo "Input: '{$inputCode}'\n";

    // Current logic from controller
    $trackingCode = trim(strtoupper($inputCode));
    echo "Normalized: '{$trackingCode}'\n";

    $student = Student::where('unique_code', $trackingCode)->first();

    if (!$student) {
        echo "❌ Result: Student not found\n";
        return false;
    } else {
        echo "✅ Result: Found student - {$student->name}\n";
        return true;
    }
}

// Test various inputs
$testCases = [
    'DS2025D5BE89',          // Exact match
    'ds2025d5be89',          // Lowercase
    '  DS2025D5BE89  ',      // With spaces
    'DS2025d5be89',          // Mixed case
    'INVALID123',            // Invalid
    '',                      // Empty
    '   ',                   // Only spaces
];

foreach ($testCases as $test) {
    echo "\n--- Test Case ---\n";
    testTrackProgress($test);
}

echo "\n=== Database Check ===\n";

// Check actual codes in database
$codes = Student::pluck('unique_code')->toArray();
echo "All unique codes in database:\n";
foreach (array_slice($codes, 0, 5) as $code) {
    echo "- {$code}\n";
}

// Check if there are any null/empty codes
$nullCodes = Student::whereNull('unique_code')->count();
$emptyCodes = Student::where('unique_code', '')->count();

echo "\nCode statistics:\n";
echo "- Total students: " . Student::count() . "\n";
echo "- Null codes: {$nullCodes}\n";
echo "- Empty codes: {$emptyCodes}\n";
echo "- Valid codes: " . (Student::count() - $nullCodes - $emptyCodes) . "\n";
