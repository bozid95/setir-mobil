<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\Schema;

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== CHECKING FINANCES TABLE STRUCTURE ===\n\n";

try {
    if (Schema::hasTable('finances')) {
        $columns = Schema::getColumnListing('finances');
        echo "Finances table columns: " . implode(', ', $columns) . "\n\n";

        // Get some sample data
        $finances = \App\Models\Finance::take(3)->get();
        echo "Sample finance records:\n";
        foreach ($finances as $finance) {
            echo "- ID: {$finance->id}, Student: {$finance->student_id}, Amount: {$finance->amount}, Type: {$finance->type}, Status: {$finance->status}\n";
        }
    } else {
        echo "Finances table does not exist\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
