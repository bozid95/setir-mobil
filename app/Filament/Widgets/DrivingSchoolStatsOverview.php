<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Session;
use App\Models\Instructor;
use App\Models\Package;
use App\Models\Finance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class DrivingSchoolStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Students', Student::count())
                ->description('All registered students')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Active Sessions', Session::whereHas('students')->count())
                ->description('Sessions with enrolled students')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Instructors', Instructor::count())
                ->description('Available instructors')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Available Packages', Package::count())
                ->description('Training packages offered')
                ->descriptionIcon('heroicon-m-cube')
                ->color('warning'),

            Stat::make('Total Sessions', Session::count())
                ->description('All training sessions')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('secondary'),

            Stat::make('This Month\'s Revenue', 'Rp ' . number_format(
                Finance::where('type', 'income')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->sum('amount'),
                0,
                ',',
                '.'
            ))
                ->description('Revenue for ' . now()->format('F Y'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
