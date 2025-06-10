<?php

require_once 'vendor/autoload.php';

use App\Models\Package;
use App\Models\Instructor;
use App\Models\Material;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentSession;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CREATING SAMPLE DATA ===\n\n";

try {
    // Create packages
    $packages = [
        ['name' => 'Basic Driving Course', 'description' => 'Basic driving lessons for beginners', 'price' => 500000, 'duration' => 20],
        ['name' => 'Advanced Driving Course', 'description' => 'Advanced driving techniques', 'price' => 750000, 'duration' => 30],
        ['name' => 'Premium Driving Course', 'description' => 'Complete driving course with all features', 'price' => 1000000, 'duration' => 40],
    ];

    foreach ($packages as $packageData) {
        Package::firstOrCreate(['name' => $packageData['name']], $packageData);
    }
    echo "✓ Created packages\n";    // Create instructors
    $instructors = [
        ['name' => 'John Doe', 'email' => 'john@example.com', 'phone_number' => '081234567890', 'license_number' => 'LIC001', 'experience_years' => 5],
        ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone_number' => '081234567891', 'license_number' => 'LIC002', 'experience_years' => 8],
        ['name' => 'Bob Johnson', 'email' => 'bob@example.com', 'phone_number' => '081234567892', 'license_number' => 'LIC003', 'experience_years' => 3],
    ];

    foreach ($instructors as $instructorData) {
        Instructor::updateOrCreate(['email' => $instructorData['email']], $instructorData);
    }
    echo "✓ Created instructors\n";

    // Create materials
    $materials = [
        ['name' => 'Traffic Rules Video', 'description' => 'Basic traffic rules video', 'type' => 'video', 'file_path' => '/videos/traffic-rules.mp4'],
        ['name' => 'Vehicle Controls Manual', 'description' => 'Manual for vehicle controls', 'type' => 'document', 'file_path' => '/docs/vehicle-controls.pdf'],
        ['name' => 'Parking Quiz', 'description' => 'Quiz about parking techniques', 'type' => 'quiz', 'file_path' => null],
    ];

    foreach ($materials as $materialData) {
        Material::firstOrCreate(['name' => $materialData['name']], $materialData);
    }
    echo "✓ Created materials\n";

    // Create sessions with instructors
    $packages = Package::all();
    $instructors = Instructor::all();

    foreach ($packages as $package) {
        for ($i = 1; $i <= 4; $i++) {
            Session::firstOrCreate([
                'package_id' => $package->id,
                'order' => $i
            ], [
                'instructor_id' => $instructors->random()->id,
                'title' => "Session $i - " . $package->name,
                'description' => "Session $i for package: " . $package->name,
            ]);
        }
    }
    echo "✓ Created sessions with instructor assignments\n";

    // Create students
    $students = [
        ['name' => 'Alice Cooper', 'email' => 'alice@example.com', 'phone_number' => '081234567893', 'register_date' => now(), 'unique_code' => 'STU001', 'package_id' => $packages->first()->id],
        ['name' => 'David Wilson', 'email' => 'david@example.com', 'phone_number' => '081234567894', 'register_date' => now(), 'unique_code' => 'STU002', 'package_id' => $packages->skip(1)->first()->id],
        ['name' => 'Emma Davis', 'email' => 'emma@example.com', 'phone_number' => '081234567895', 'register_date' => now(), 'unique_code' => 'STU003', 'package_id' => $packages->first()->id],
    ];

    foreach ($students as $studentData) {
        Student::firstOrCreate(['unique_code' => $studentData['unique_code']], $studentData);
    }
    echo "✓ Created students\n";

    // Create student sessions with grades
    $students = Student::all();

    foreach ($students as $student) {
        $sessions = Session::where('package_id', $student->package_id)->get();

        foreach ($sessions as $session) {
            $studentSession = StudentSession::firstOrCreate([
                'student_id' => $student->id,
                'session_id' => $session->id,
            ], [
                'date' => now()->addDays(rand(1, 30)),
                'status' => ['present', 'absent', 'excused'][rand(0, 2)],
                'score' => rand(70, 100),
                'grade' => ['A', 'B', 'C'][rand(0, 2)],
                'instructor_feedback' => 'Student showed good progress in this session.',
                'notes' => 'Session completed successfully.',
            ]);
        }
    }
    echo "✓ Created student sessions with grades\n";

    echo "\n=== SAMPLE DATA CREATION COMPLETE ===\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
