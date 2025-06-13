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
        Schema::table('driving_sessions', function (Blueprint $table) {
            // Drop columns that are no longer needed
            $table->dropColumn(['instructor_id', 'title', 'duration_minutes', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driving_sessions', function (Blueprint $table) {
            // Restore the dropped columns
            $table->unsignedBigInteger('instructor_id')->nullable()->after('package_id');
            $table->string('title')->nullable()->after('order');
            $table->integer('duration_minutes')->default(60)->after('description');
            $table->boolean('is_active')->default(true)->after('duration_minutes');
        });
    }
};
