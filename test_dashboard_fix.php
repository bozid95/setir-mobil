<?php

/**
 * Dashboard Fix Test
 * Check what's causing dashboard issues
 */

echo "🔧 TESTING DASHBOARD ISSUES\n";
echo "===========================\n\n";

try {
    // Test 1: Check basic Laravel connection
    echo "1. Testing Laravel Application...\n";
    require_once 'vendor/autoload.php';
    $app = require_once 'bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "   ✅ Laravel application bootstrapped\n";

    // Test 2: Check database connection
    echo "\n2. Testing Database Connection...\n";
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        echo "   ✅ Database connection successful\n";
    } catch (Exception $e) {
        echo "   ❌ Database connection failed: " . $e->getMessage() . "\n";
        return;
    }

    // Test 3: Check critical tables
    echo "\n3. Testing Critical Tables...\n";

    $criticalTables = ['users', 'students', 'finances', 'packages', 'driving_sessions'];
    foreach ($criticalTables as $table) {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
                $count = \Illuminate\Support\Facades\DB::table($table)->count();
                echo "   ✅ {$table} table exists ({$count} records)\n";
            } else {
                echo "   ❌ {$table} table missing\n";
            }
        } catch (Exception $e) {
            echo "   ❌ {$table} table error: " . $e->getMessage() . "\n";
        }
    }

    // Test 4: Check Finance table structure
    echo "\n4. Testing Finance Table Structure...\n";
    try {
        if (\Illuminate\Support\Facades\Schema::hasTable('finances')) {
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing('finances');
            echo "   ✅ Finance columns: " . implode(', ', $columns) . "\n";

            // Check for old installment columns
            $hasInstallmentNumber = in_array('installment_number', $columns);
            $hasParentFinanceId = in_array('parent_finance_id', $columns);

            if ($hasInstallmentNumber || $hasParentFinanceId) {
                echo "   ⚠️  Old installment columns still exist - this might cause issues\n";
                if ($hasInstallmentNumber) echo "      - Found: installment_number\n";
                if ($hasParentFinanceId) echo "      - Found: parent_finance_id\n";
            } else {
                echo "   ✅ Finance table structure is clean\n";
            }
        } else {
            echo "   ❌ Finances table doesn't exist\n";
        }
    } catch (Exception $e) {
        echo "   ❌ Finance table check failed: " . $e->getMessage() . "\n";
    }

    // Test 5: Test Finance model
    echo "\n5. Testing Finance Model...\n";
    try {
        $finance = new \App\Models\Finance();
        echo "   ✅ Finance model instantiated\n";

        // Check fillable fields
        $fillable = $finance->getFillable();
        echo "   📋 Fillable fields: " . implode(', ', $fillable) . "\n";
    } catch (Exception $e) {
        echo "   ❌ Finance model error: " . $e->getMessage() . "\n";
    }

    // Test 6: Check widget files
    echo "\n6. Testing Widget Files...\n";
    $widgets = [
        'DrivingSchoolStatsOverview',
        'FinanceStatsOverview',
        'PaymentStatusChart',
        'MonthlyFinanceChart',
        'OverduePaymentsWidget',
        'RecentPaymentsWidget'
    ];

    foreach ($widgets as $widget) {
        $path = "app/Filament/Widgets/{$widget}.php";
        if (file_exists($path)) {
            echo "   ✅ {$widget} exists\n";
        } else {
            echo "   ❌ {$widget} missing\n";
        }
    }

    echo "\n" . str_repeat("=", 50) . "\n";
    echo "🎯 DASHBOARD DIAGNOSIS RESULTS\n";
    echo str_repeat("=", 50) . "\n";
    echo "✅ Dashboard test completed successfully!\n";
    echo "📝 Next steps to fix dashboard:\n";
    echo "1. Run 'php artisan config:clear'\n";
    echo "2. Run 'php artisan cache:clear'\n";
    echo "3. Check if migrations need to be run\n";
    echo "4. Test accessing /admin dashboard\n";
} catch (Exception $e) {
    echo "\n❌ Critical error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
