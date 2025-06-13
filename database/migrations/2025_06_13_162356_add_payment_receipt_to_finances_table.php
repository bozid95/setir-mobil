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
        Schema::table('finances', function (Blueprint $table) {
            $table->string('payment_receipt')->nullable()->after('payment_date');
            $table->text('receipt_notes')->nullable()->after('payment_receipt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finances', function (Blueprint $table) {
            $table->dropColumn(['payment_receipt', 'receipt_notes']);
        });
    }
};
