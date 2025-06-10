<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== MANUAL DATABASE SETUP ===\n\n";

try {
    // Create packages table if not exists
    if (!Schema::hasTable('packages')) {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('duration'); // in hours
            $table->timestamps();
        });
        echo "✓ Created packages table\n";
    }

    // Create instructors table if not exists
    if (!Schema::hasTable('instructors')) {
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('license_number')->nullable();
            $table->integer('experience_years')->nullable();
            $table->timestamps();
        });
        echo "✓ Created instructors table\n";
    }

    // Create materials table if not exists
    if (!Schema::hasTable('materials')) {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('type'); // video, document, quiz, etc.
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
        echo "✓ Created materials table\n";
    }

    // Create driving_sessions table with instructor_id
    if (!Schema::hasTable('driving_sessions')) {
        Schema::create('driving_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->foreignId('instructor_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('order');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('instructor_id');
        });
        echo "✓ Created driving_sessions table with instructor_id\n";
    }

    // Create session_materials table if not exists
    if (!Schema::hasTable('session_materials')) {
        Schema::create('session_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('driving_sessions')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
        echo "✓ Created session_materials table\n";
    }

    // Create students table without instructor_id
    if (!Schema::hasTable('students')) {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable(); // No unique constraint
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->date('register_date')->nullable();
            $table->string('unique_code')->nullable()->unique();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->index('package_id');
        });
        echo "✓ Created students table without instructor_id\n";
    }

    // Create student_sessions table with grading columns
    if (!Schema::hasTable('student_sessions')) {
        Schema::create('student_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('session_id')->constrained('driving_sessions')->cascadeOnDelete();
            $table->dateTime('date')->nullable();
            $table->string('status')->nullable(); // present, absent, excused, etc.
            $table->decimal('score', 5, 2)->nullable()->comment('Score out of 100');
            $table->string('grade', 2)->nullable()->comment('Letter grade: A, B, C, D, F');
            $table->text('instructor_feedback')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('student_id');
            $table->index('session_id');
        });
        echo "✓ Created student_sessions table with grading columns\n";
    }

    // Create finances table if not exists
    if (!Schema::hasTable('finances')) {
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // income, expense
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->date('date');
            $table->string('status')->default('completed');
            $table->timestamps();
        });
        echo "✓ Created finances table\n";
    }

    echo "\n=== DATABASE SETUP COMPLETE ===\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
