<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Models\Package;

echo "=== CHECKING STUDENT DATA ===\n\n";

$students = Student::all();
echo "Total students: " . $students->count() . "\n\n";

foreach ($students as $student) {
    echo "Student ID: {$student->id}\n";
    echo "Name: {$student->name}\n";
    echo "Unique Code: '{$student->unique_code}'\n";
    echo "Package ID: {$student->package_id}\n";
    echo "Email: {$student->email}\n";
    echo "Created: {$student->created_at}\n";
    echo "---\n";
}

// Check which students don't have unique codes
$studentsWithoutCode = Student::whereNull('unique_code')->orWhere('unique_code', '')->get();
echo "\nStudents without unique code: " . $studentsWithoutCode->count() . "\n";

// Fix students without unique codes
if ($studentsWithoutCode->count() > 0) {
    echo "\nFixing students without unique codes...\n";
    foreach ($studentsWithoutCode as $student) {
        $newCode = 'DS' . date('Y') . strtoupper(substr(md5($student->id . time()), 0, 6));
        $student->unique_code = $newCode;
        $student->save();
        echo "Fixed student {$student->name}: {$newCode}\n";
    }
}

echo "\n=== TESTING DASHBOARD ACCESS ===\n";
$testStudent = Student::first();
if ($testStudent && $testStudent->unique_code) {
    $url = "http://localhost:8000/student/{$testStudent->unique_code}";
    echo "Test URL: {$url}\n";
    echo "Student: {$testStudent->name}\n";
    echo "Code: {$testStudent->unique_code}\n";
} else {
    echo "❌ No valid student found for testing\n";
}
