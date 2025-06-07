<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop tables if they exist
        Schema::dropIfExists('payments');
        Schema::dropIfExists('meets');
        Schema::dropIfExists('students');
        Schema::dropIfExists('instructors');
        Schema::dropIfExists('packets');

        // Create new tables according to the schema
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });

        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->integer('order');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('session_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('training_sessions')->cascadeOnDelete();
            $table->foreignId('material_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            // Add index to improve query performance
            $table->index('session_id');
            $table->index('material_id');
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->date('register_date')->nullable();
            $table->string('unique_code')->nullable()->unique();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('instructor_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->timestamps();

            // Add indexes to improve query performance
            $table->index('instructor_id');
            $table->index('package_id');
        });
        Schema::create('student_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('session_id')->constrained('training_sessions')->cascadeOnDelete();
            $table->dateTime('date')->nullable();
            $table->string('status')->nullable(); // present, absent, excused, etc.
            $table->text('notes')->nullable();
            $table->timestamps();

            // Add indexes to improve query performance
            $table->index('student_id');
            $table->index('session_id');
        });

        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->dateTime('date');
            $table->decimal('amount', 10, 2);
            $table->string('type'); // income/expense
            $table->text('description')->nullable();
            $table->timestamps();

            // Add index to improve query performance
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop new tables
        Schema::dropIfExists('finances');
        Schema::dropIfExists('student_sessions');
        Schema::dropIfExists('students');
        Schema::dropIfExists('session_materials');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('materials');
        Schema::dropIfExists('instructors');
        Schema::dropIfExists('packages');
    }
};
