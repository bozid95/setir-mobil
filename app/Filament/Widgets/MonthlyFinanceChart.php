<?php

namespace App\Filament\Widgets;

use App\Models\Finance;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class MonthlyFinanceChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Finance Trends';

    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create(date('Y'), $month)->format('M');
        });

        $monthlyRevenue = collect(range(1, 12))->map(function ($month) {
            return Finance::whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->where('status', 'paid')
                ->sum('amount');
        });

        $monthlyPending = collect(range(1, 12))->map(function ($month) {
            return Finance::whereMonth('created_at', $month)
                ->whereYear('created_at', date('Y'))
                ->where('status', 'pending')
                ->sum('amount');
        });

        return [
            'datasets' => [
                [
                    'label' => 'Completed Revenue',
                    'data' => $monthlyRevenue->values()->toArray(),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'borderColor' => 'rgb(34, 197, 94)',
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Pending Payments',
                    'data' => $monthlyPending->values()->toArray(),
                    'backgroundColor' => 'rgba(251, 191, 36, 0.1)',
                    'borderColor' => 'rgb(251, 191, 36)',
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
