<?php

namespace App\Filament\Widgets;

use App\Models\Finance;
use Filament\Widgets\ChartWidget;

class PaymentStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Payment Status';

    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $paidCount = Finance::where('status', 'paid')->count();
        $pendingCount = Finance::where('status', 'pending')->count();
        $overdueCount = Finance::where('status', 'pending')
            ->where('due_date', '<', now())
            ->whereNotNull('due_date')
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Payment Status',
                    'data' => [$paidCount, $pendingCount, $overdueCount],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)',   // green for paid
                        'rgb(251, 191, 36)',  // yellow for pending
                        'rgb(239, 68, 68)',   // red for overdue
                    ],
                ],
            ],
            'labels' => ['Paid', 'Pending', 'Overdue'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
