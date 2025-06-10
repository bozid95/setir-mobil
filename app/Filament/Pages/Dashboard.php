<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Driving School Dashboard';

    protected static string $view = 'filament.pages.dashboard';

    public function getWidgets(): array
    {
        return [
            // Essential Overview Stats (Top Priority)
            \App\Filament\Widgets\DrivingSchoolStatsOverview::class,
            \App\Filament\Widgets\FinanceStatsOverview::class,

            // Critical Finance Information
            \App\Filament\Widgets\OverduePaymentsWidget::class,

            // Key Activity Data
            \App\Filament\Widgets\LatestStudents::class,
        ];
    }

    public function getColumns(): int | string | array
    {
        return [
            'sm' => 1,
            'md' => 2,
            'xl' => 2,
        ];
    }
}
