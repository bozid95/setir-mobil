<?php

namespace App\Filament\Widgets;

use App\Models\Finance;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlyRevenueStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $currentMonth = now();
        $lastMonth = now()->subMonth();

        // Current month revenue - include all income types
        $thisMonthRevenue = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('amount');

        // Last month revenue for comparison
        $lastMonthRevenue = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
            ->whereMonth('created_at', $lastMonth->month)
            ->whereYear('created_at', $lastMonth->year)
            ->sum('amount');

        // Calculate growth percentage
        $growthPercentage = 0;
        if ($lastMonthRevenue > 0) {
            $growthPercentage = (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100;
        }

        // This month's transactions count
        $thisMonthTransactions = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->count();

        // Paid vs pending
        $paidThisMonth = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
            ->where('status', 'paid')
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('amount');

        $pendingThisMonth = Finance::whereIn('type', ['registration', 'tuition', 'material', 'exam'])
            ->where('status', 'pending')
            ->whereMonth('created_at', $currentMonth->month)
            ->whereYear('created_at', $currentMonth->year)
            ->sum('amount');

        return [
            Stat::make('This Month Revenue', 'Rp ' . number_format($thisMonthRevenue, 0, ',', '.'))
                ->description(
                    $growthPercentage > 0
                        ? '+' . number_format($growthPercentage, 1) . '% from last month'
                        : ($growthPercentage < 0
                            ? number_format($growthPercentage, 1) . '% from last month'
                            : 'No change from last month')
                )
                ->descriptionIcon(
                    $growthPercentage > 0
                        ? 'heroicon-m-arrow-trending-up'
                        : ($growthPercentage < 0
                            ? 'heroicon-m-arrow-trending-down'
                            : 'heroicon-m-minus')
                )
                ->color(
                    $growthPercentage > 0
                        ? 'success'
                        : ($growthPercentage < 0 ? 'danger' : 'gray')
                ),

            Stat::make('Revenue Received', 'Rp ' . number_format($paidThisMonth, 0, ',', '.'))
                ->description('Paid transactions this month')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Pending Revenue', 'Rp ' . number_format($pendingThisMonth, 0, ',', '.'))
                ->description('Awaiting payment')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Transactions Count', $thisMonthTransactions)
                ->description('Total income transactions')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
