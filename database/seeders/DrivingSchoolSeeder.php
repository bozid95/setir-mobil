<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;
use App\Models\Instructor;
use App\Models\Material;
use App\Models\Session;
use App\Models\SessionMaterial;
use App\Models\Student;
use App\Models\StudentSession;
use App\Models\Finance;

class DrivingSchoolSeeder extends Seeder
{
    /**
     * Seed the driving school data.
     */
    public function run(): void
    {
        // Create packages
        $packages = [
            [
                'name' => 'Basic Driving Course',
                'description' => 'Learn the basics of driving in 5 sessions',
                'price' => 500000,
            ],
            [
                'name' => 'Advanced Driving Course',
                'description' => 'Master advanced driving techniques in 10 sessions',
                'price' => 1000000,
            ],
            [
                'name' => 'Premium Driving Course',
                'description' => 'Complete driving training with 15 sessions',
                'price' => 1500000,
            ],
        ];

        foreach ($packages as $packageData) {
            Package::create($packageData);
        }

        // Create instructors
        $instructors = [
            ['name' => 'John Doe'],
            ['name' => 'Jane Smith'],
            ['name' => 'Robert Johnson'],
        ];

        foreach ($instructors as $instructorData) {
            Instructor::create($instructorData);
        }

        // Create materials
        $materials = [
            ['name' => 'Basic Car Controls', 'description' => 'Learn about the basic controls of a car'],
            ['name' => 'Parking Techniques', 'description' => 'Different methods of parking'],
            ['name' => 'Highway Driving', 'description' => 'Rules and techniques for highway driving'],
            ['name' => 'Defensive Driving', 'description' => 'How to drive defensively and avoid accidents'],
        ];

        foreach ($materials as $materialData) {
            Material::create($materialData);
        }

        // Create sessions for each package
        $basicPackage = Package::where('name', 'Basic Driving Course')->first();
        $advancedPackage = Package::where('name', 'Advanced Driving Course')->first();

        // Basic package sessions
        $basicSessions = [
            ['package_id' => $basicPackage->id, 'order' => 1, 'title' => 'Introduction to Driving', 'description' => 'Get familiar with the car and basic controls'],
            ['package_id' => $basicPackage->id, 'order' => 2, 'title' => 'Basic Maneuvers', 'description' => 'Practice starting, stopping, and turning'],
            ['package_id' => $basicPackage->id, 'order' => 3, 'title' => 'Road Rules', 'description' => 'Learn important road rules and signs'],
            ['package_id' => $basicPackage->id, 'order' => 4, 'title' => 'Parking Practice', 'description' => 'Practice different parking techniques'],
            ['package_id' => $basicPackage->id, 'order' => 5, 'title' => 'Final Assessment', 'description' => 'Evaluate your driving skills'],
        ];

        foreach ($basicSessions as $sessionData) {
            Session::create($sessionData);
        }

        // Advanced package sessions (just a few examples)
        $advancedSessions = [
            ['package_id' => $advancedPackage->id, 'order' => 1, 'title' => 'Advanced Vehicle Control', 'description' => 'Master precise vehicle control techniques'],
            ['package_id' => $advancedPackage->id, 'order' => 2, 'title' => 'Defensive Driving', 'description' => 'Learn to anticipate and avoid hazards'],
            ['package_id' => $advancedPackage->id, 'order' => 3, 'title' => 'Night Driving', 'description' => 'Practice driving safely at night'],
        ];

        foreach ($advancedSessions as $sessionData) {
            Session::create($sessionData);
        }

        // Create some students
        $students = [
            [
                'name' => 'Michael Brown',
                'email' => 'michael@example.com',
                'phone_number' => '08123456789',
                'address' => 'Jl. Sudirman No. 123',
                'register_date' => now(),
                'unique_code' => 'STD-001',
                'instructor_id' => 1,
                'package_id' => 1,
            ],
            [
                'name' => 'Sarah Williams',
                'email' => 'sarah@example.com',
                'phone_number' => '08123456790',
                'address' => 'Jl. Thamrin No. 456',
                'register_date' => now(),
                'unique_code' => 'STD-002',
                'instructor_id' => 2,
                'package_id' => 2,
            ],
        ];

        foreach ($students as $studentData) {
            Student::create($studentData);
        }

        // Create some finances
        $finances = [
            [
                'student_id' => 1,
                'date' => now(),
                'amount' => 500000,
                'type' => 'income',
                'description' => 'Payment for Basic Driving Course',
            ],
            [
                'student_id' => 2,
                'date' => now(),
                'amount' => 500000,
                'type' => 'income',
                'description' => 'First payment for Advanced Driving Course',
            ],
        ];

        foreach ($finances as $financeData) {
            Finance::create($financeData);
        }

        // Create session materials
        $sessionMaterials = [
            ['session_id' => 1, 'material_id' => 1], // Basic Controls for Intro to Driving
            ['session_id' => 4, 'material_id' => 2], // Parking Techniques for Parking Practice
            ['session_id' => 6, 'material_id' => 4], // Defensive Driving for Advanced Defensive Driving
        ];

        foreach ($sessionMaterials as $sessionMaterialData) {
            SessionMaterial::create($sessionMaterialData);
        }

        // Create student sessions (progress tracking)
        $studentSessions = [
            [
                'student_id' => 1,
                'session_id' => 1,
                'date' => now()->subDays(7)->setTime(10, 0),
                'status' => 'completed',
                'notes' => 'Student did well, understands basic controls',
            ],
            [
                'student_id' => 1,
                'session_id' => 2,
                'date' => now()->subDays(3)->setTime(14, 30),
                'status' => 'completed',
                'notes' => 'Good progress with basic maneuvers',
            ],
            [
                'student_id' => 2,
                'session_id' => 6,
                'date' => now()->subDays(5)->setTime(9, 15),
                'status' => 'completed',
                'notes' => 'Excellent understanding of defensive driving concepts',
            ],
            [
                'student_id' => 1,
                'session_id' => 3,
                'date' => now()->addDays(2)->setTime(13, 0),
                'status' => 'scheduled',
                'notes' => 'Next session: Highway driving practice',
            ],
            [
                'student_id' => 2,
                'session_id' => 7,
                'date' => now()->addDays(4)->setTime(16, 30),
                'status' => 'scheduled',
                'notes' => 'Advanced traffic navigation session',
            ],
        ];

        foreach ($studentSessions as $studentSessionData) {
            StudentSession::create($studentSessionData);
        }
    }
}
