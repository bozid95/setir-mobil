<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;

echo "=== TRACK PROGRESS TESTING ===\n";

// Get a real student
$student = Student::first();
if ($student) {
    echo "Test Student Found:\n";
    echo "- Name: " . $student->name . "\n";
    echo "- Unique Code: " . $student->unique_code . "\n";
    echo "- Email: " . $student->email . "\n";

    // Test if unique code search works
    $found = Student::where('unique_code', $student->unique_code)->first();
    if ($found) {
        echo "✅ Student found by unique code search\n";
    } else {
        echo "❌ Student NOT found by unique code search\n";
    }

    // Test case sensitivity
    $foundLower = Student::where('unique_code', strtolower($student->unique_code))->first();
    $foundUpper = Student::where('unique_code', strtoupper($student->unique_code))->first();

    echo "Code variations:\n";
    echo "- Original: " . $student->unique_code . "\n";
    echo "- Lowercase: " . strtolower($student->unique_code) . " - " . ($foundLower ? "Found" : "Not Found") . "\n";
    echo "- Uppercase: " . strtoupper($student->unique_code) . " - " . ($foundUpper ? "Found" : "Not Found") . "\n";

    // Test with manual codes
    echo "\n=== Testing Track Progress Logic ===\n";

    $testCodes = [
        $student->unique_code,  // Original
        strtoupper($student->unique_code),  // Uppercase
        strtolower($student->unique_code),  // Lowercase
        'INVALID123',  // Invalid code
    ];

    foreach ($testCodes as $testCode) {
        $trimmedCode = trim(strtoupper($testCode));
        $foundStudent = Student::where('unique_code', $trimmedCode)->first();

        echo "Test Code: '{$testCode}' -> Normalized: '{$trimmedCode}' -> ";
        echo ($foundStudent ? "✅ Found: " . $foundStudent->name : "❌ Not Found") . "\n";
    }
} else {
    echo "❌ No students found in database\n";
}

// Check routes
echo "\nRoutes:\n";
try {
    echo "- Track: " . route('student.track') . "\n";
    echo "- Dashboard: " . route('student.dashboard', ['code' => 'TEST123']) . "\n";
} catch (Exception $e) {
    echo "❌ Route error: " . $e->getMessage() . "\n";
}

echo "\n=== CHECKING STUDENTS TABLE ===\n";
$totalStudents = Student::count();
echo "Total students: {$totalStudents}\n";

if ($totalStudents > 0) {
    echo "Sample students:\n";
    $students = Student::take(3)->get(['name', 'unique_code', 'email']);
    foreach ($students as $s) {
        echo "- {$s->name} | {$s->unique_code} | {$s->email}\n";
    }
}
