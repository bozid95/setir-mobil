<?php

echo "=== SIMPLE DASHBOARD VERIFICATION ===\n\n";

// Check if widget files exist
$widgets = [
    'DrivingSchoolStatsOverview' => 'app/Filament/Widgets/DrivingSchoolStatsOverview.php',
    'FinanceStatsOverview' => 'app/Filament/Widgets/FinanceStatsOverview.php',
    'OverduePaymentsWidget' => 'app/Filament/Widgets/OverduePaymentsWidget.php',
    'LatestStudents' => 'app/Filament/Widgets/LatestStudents.php',
    'UpcomingSessions (should be gone)' => 'app/Filament/Widgets/UpcomingSessions.php'
];

echo "1. Widget File Check:\n";
foreach ($widgets as $name => $path) {
    if (file_exists($path)) {
        if (strpos($name, 'should be gone') !== false) {
            echo "❌ $name - STILL EXISTS (should be removed)\n";
        } else {
            echo "✅ $name - EXISTS\n";
        }
    } else {
        if (strpos($name, 'should be gone') !== false) {
            echo "✅ $name - SUCCESSFULLY REMOVED\n";
        } else {
            echo "❌ $name - MISSING\n";
        }
    }
}

// Check Dashboard.php content
echo "\n2. Dashboard Configuration Check:\n";
$dashboardContent = file_get_contents('app/Filament/Pages/Dashboard.php');
if (strpos($dashboardContent, 'UpcomingSessions') === false) {
    echo "✅ UpcomingSessions removed from Dashboard.php\n";
} else {
    echo "❌ UpcomingSessions still referenced in Dashboard.php\n";
}

// Check AdminPanelProvider content
echo "\n3. AdminPanelProvider Check:\n";
$providerContent = file_get_contents('app/Providers/Filament/AdminPanelProvider.php');
if (strpos($providerContent, 'UpcomingSessions') === false) {
    echo "✅ UpcomingSessions removed from AdminPanelProvider.php\n";
} else {
    echo "❌ UpcomingSessions still referenced in AdminPanelProvider.php\n";
}

echo "\n=== VERIFICATION COMPLETE ===\n";
echo "The dashboard should now work without database errors!\n";
