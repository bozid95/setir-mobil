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
        Schema::table('students', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->after('name');
            $table->string('place_of_birth')->nullable()->after('gender');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->string('occupation')->nullable()->after('date_of_birth');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['gender', 'place_of_birth', 'date_of_birth', 'occupation']);
        });
    }
};
