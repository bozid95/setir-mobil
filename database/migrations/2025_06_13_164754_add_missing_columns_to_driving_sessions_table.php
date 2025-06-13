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
            // Add missing columns that models/resources expect
            $table->integer('order')->after('instructor_id')->default(0);
            $table->string('title')->after('order')->nullable();

            // Rename 'name' to avoid confusion (if still exists)
            // The 'name' column in original migration should be used as 'title'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('driving_sessions', function (Blueprint $table) {
            $table->dropColumn(['order', 'title']);
        });
    }
};
