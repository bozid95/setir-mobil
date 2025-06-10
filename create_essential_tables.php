<?php

/**
 * Create Essential Tables for Dashboard
 * Direct database table creation to fix dashboard
 */

echo "🛠️ CREATING ESSENTIAL TABLES FOR DASHBOARD\n";
echo "===========================================\n\n";

try {
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "1. Creating packages table...\n";
    \Illuminate\Support\Facades\DB::statement("
        CREATE TABLE IF NOT EXISTS packages (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            duration_hours INT DEFAULT 0,
            is_active BOOLEAN DEFAULT 1,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )
    ");
    echo "   ✅ Packages table created\n";

    echo "\n2. Creating instructors table...\n";
    \Illuminate\Support\Facades\DB::statement("
        CREATE TABLE IF NOT EXISTS instructors (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) UNIQUE NOT NULL,
            phone_number VARCHAR(255),
            address TEXT,
            license_number VARCHAR(255),
            license_expiry DATE,
            is_active BOOLEAN DEFAULT 1,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )
    ");
    echo "   ✅ Instructors table created\n";

    echo "\n3. Creating students table...\n";
    \Illuminate\Support\Facades\DB::statement("
        CREATE TABLE IF NOT EXISTS students (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255),
            phone_number VARCHAR(255),
            address TEXT,
            register_date DATE NOT NULL,
            unique_code VARCHAR(255),
            package_id BIGINT UNSIGNED NOT NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE
        )
    ");
    echo "   ✅ Students table created\n";

    echo "\n4. Creating driving_sessions table...\n";
    \Illuminate\Support\Facades\DB::statement("
        CREATE TABLE IF NOT EXISTS driving_sessions (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            description TEXT,
            package_id BIGINT UNSIGNED NOT NULL,
            instructor_id BIGINT UNSIGNED,
            duration_minutes INT DEFAULT 60,
            is_active BOOLEAN DEFAULT 1,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (package_id) REFERENCES packages(id) ON DELETE CASCADE,
            FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE SET NULL
        )
    ");
    echo "   ✅ Driving sessions table created\n";

    echo "\n5. Creating student_sessions table...\n";
    \Illuminate\Support\Facades\DB::statement("
        CREATE TABLE IF NOT EXISTS student_sessions (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            student_id BIGINT UNSIGNED NOT NULL,
            session_id BIGINT UNSIGNED NOT NULL,
            instructor_id BIGINT UNSIGNED,
            scheduled_date DATETIME NOT NULL,
            status ENUM('scheduled', 'completed', 'cancelled') DEFAULT 'scheduled',
            notes TEXT,
            score DECIMAL(5,2),
            grade VARCHAR(2),
            instructor_feedback TEXT,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
            FOREIGN KEY (session_id) REFERENCES driving_sessions(id) ON DELETE CASCADE,
            FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE SET NULL
        )
    ");
    echo "   ✅ Student sessions table created\n";

    echo "\n6. Creating finances table...\n";
    \Illuminate\Support\Facades\DB::statement("
        CREATE TABLE IF NOT EXISTS finances (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            student_id BIGINT UNSIGNED NOT NULL,
            date DATETIME NOT NULL,
            amount DECIMAL(10,2) NOT NULL,
            type ENUM('tuition', 'registration', 'material', 'exam', 'certificate', 'penalty') NOT NULL,
            description TEXT,
            status ENUM('pending', 'paid', 'cancelled') DEFAULT 'pending',
            due_date DATE NOT NULL,
            payment_date DATETIME,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
        )
    ");
    echo "   ✅ Finances table created\n";

    echo "\n7. Inserting sample data...\n";

    // Insert sample packages
    \Illuminate\Support\Facades\DB::table('packages')->insertOrIgnore([
        ['name' => 'Basic Package', 'description' => 'Basic driving course', 'price' => 2000000, 'duration_hours' => 20, 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Standard Package', 'description' => 'Standard driving course', 'price' => 3000000, 'duration_hours' => 30, 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Premium Package', 'description' => 'Premium driving course', 'price' => 4000000, 'duration_hours' => 40, 'created_at' => now(), 'updated_at' => now()],
    ]);
    echo "   ✅ Sample packages inserted\n";

    // Insert sample instructors
    \Illuminate\Support\Facades\DB::table('instructors')->insertOrIgnore([
        ['name' => 'John Instructor', 'email' => 'john@driving.com', 'phone_number' => '081234567890', 'license_number' => 'LIC001', 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Jane Teacher', 'email' => 'jane@driving.com', 'phone_number' => '081234567891', 'license_number' => 'LIC002', 'created_at' => now(), 'updated_at' => now()],
    ]);
    echo "   ✅ Sample instructors inserted\n";

    // Insert sample students
    \Illuminate\Support\Facades\DB::table('students')->insertOrIgnore([
        ['name' => 'Alice Student', 'email' => 'alice@student.com', 'phone_number' => '081234567892', 'register_date' => now()->subDays(30), 'package_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Bob Learner', 'email' => 'bob@student.com', 'phone_number' => '081234567893', 'register_date' => now()->subDays(20), 'package_id' => 2, 'created_at' => now(), 'updated_at' => now()],
        ['name' => 'Carol Driver', 'email' => 'carol@student.com', 'phone_number' => '081234567894', 'register_date' => now()->subDays(10), 'package_id' => 3, 'created_at' => now(), 'updated_at' => now()],
    ]);
    echo "   ✅ Sample students inserted\n";

    // Insert sample finances
    \Illuminate\Support\Facades\DB::table('finances')->insertOrIgnore([
        ['student_id' => 1, 'date' => now()->subDays(25), 'amount' => 500000, 'type' => 'registration', 'description' => 'Registration fee', 'status' => 'paid', 'due_date' => now()->subDays(25), 'payment_date' => now()->subDays(25), 'created_at' => now(), 'updated_at' => now()],
        ['student_id' => 1, 'date' => now()->subDays(20), 'amount' => 1000000, 'type' => 'tuition', 'description' => 'Tuition payment 1', 'status' => 'paid', 'due_date' => now()->subDays(20), 'payment_date' => now()->subDays(18), 'created_at' => now(), 'updated_at' => now()],
        ['student_id' => 1, 'date' => now()->subDays(10), 'amount' => 1000000, 'type' => 'tuition', 'description' => 'Tuition payment 2', 'status' => 'pending', 'due_date' => now()->addDays(10), 'created_at' => now(), 'updated_at' => now()],
        ['student_id' => 2, 'date' => now()->subDays(15), 'amount' => 500000, 'type' => 'registration', 'description' => 'Registration fee', 'status' => 'paid', 'due_date' => now()->subDays(15), 'payment_date' => now()->subDays(15), 'created_at' => now(), 'updated_at' => now()],
        ['student_id' => 2, 'date' => now()->subDays(5), 'amount' => 1500000, 'type' => 'tuition', 'description' => 'Tuition payment', 'status' => 'pending', 'due_date' => now()->addDays(5), 'created_at' => now(), 'updated_at' => now()],
        ['student_id' => 3, 'date' => now()->subDays(5), 'amount' => 500000, 'type' => 'registration', 'description' => 'Registration fee', 'status' => 'pending', 'due_date' => now()->subDays(2), 'created_at' => now(), 'updated_at' => now()],
    ]);
    echo "   ✅ Sample finances inserted\n";

    echo "\n" . str_repeat("=", 50) . "\n";
    echo "🎉 SUCCESS: All essential tables created!\n";
    echo str_repeat("=", 50) . "\n";
    echo "📋 Tables created:\n";
    echo "   • packages (3 records)\n";
    echo "   • instructors (2 records)\n";
    echo "   • students (3 records)\n";
    echo "   • driving_sessions\n";
    echo "   • student_sessions\n";
    echo "   • finances (6 records)\n\n";
    echo "🚀 Dashboard should now work properly!\n";
    echo "📝 Next: Clear cache and test dashboard\n";
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
}
