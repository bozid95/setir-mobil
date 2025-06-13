<?php

namespace App\Filament\Widgets;

use App\Models\StudentSession;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TodayScheduleStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $todaySessions = StudentSession::whereDate('scheduled_date', today())
            ->with(['student', 'session', 'instructor'])
            ->orderBy('scheduled_date')
            ->get();

        $todayCount = $todaySessions->count();
        $completedToday = $todaySessions->where('status', 'completed')->count();
        $upcomingToday = $todaySessions->whereIn('status', ['scheduled'])->count();

        return [
            Stat::make('Today\'s Sessions', $todayCount)
                ->description($todayCount > 0 ? 'Sessions scheduled for today' : 'No sessions today')
                ->descriptionIcon('heroicon-m-calendar')
                ->color($todayCount > 0 ? 'primary' : 'gray'),

            Stat::make('Completed Today', $completedToday)
                ->description($completedToday > 0 ? 'Sessions completed' : 'No completed sessions')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color($completedToday > 0 ? 'success' : 'gray'),

            Stat::make('Upcoming Today', $upcomingToday)
                ->description($upcomingToday > 0 ? 'Sessions pending' : 'No pending sessions')
                ->descriptionIcon('heroicon-m-clock')
                ->color($upcomingToday > 0 ? 'warning' : 'gray'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }
}
