<?php

namespace App\Filament\Widgets;

use App\Models\Finance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinanceStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalRevenue = Finance::sum('amount');
        $pendingPayments = Finance::where('status', 'pending')->sum('amount');
        $completedPayments = Finance::where('status', 'paid')->sum('amount');
        $overduePayments = Finance::where('status', 'pending')
            ->where('due_date', '<', now())
            ->whereNotNull('due_date')
            ->sum('amount');
        return [
            Stat::make('Total Revenue', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Total revenue generated')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('success'),

            Stat::make('Completed Payments', 'Rp ' . number_format($completedPayments, 0, ',', '.'))
                ->description('Payments that have been completed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pending Payments', 'Rp ' . number_format($pendingPayments, 0, ',', '.'))
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Overdue Payments', 'Rp ' . number_format($overduePayments, 0, ',', '.'))
                ->description('Past due date')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('danger'),
        ];
    }
}
