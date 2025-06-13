<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Driving School Dashboard';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    // Make sure this dashboard takes priority
    protected static ?int $navigationSort = -2;

    public function getWidgets(): array
    {
        return [
            // Essential Overview Stats
            \App\Filament\Widgets\DrivingSchoolStatsOverview::class,

            // Today's Schedule Stats
            \App\Filament\Widgets\TodayScheduleStatsWidget::class,

            // Monthly Revenue Stats
            \App\Filament\Widgets\MonthlyRevenueStatsWidget::class,

            // Weekly Schedule
            \App\Filament\Widgets\WeeklyScheduleWidget::class,

            // Monthly Revenue Chart
            \App\Filament\Widgets\MonthlyRevenueChartWidget::class,

            // Monthly Revenue Details
            \App\Filament\Widgets\MonthlyRevenueTableWidget::class,

            // // Latest Activity
            // \App\Filament\Widgets\LatestStudents::class,

            // // Critical Finance Information
            // \App\Filament\Widgets\OverduePaymentsWidget::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'sm' => 1,
            'lg' => 3,
        ];
    }
}