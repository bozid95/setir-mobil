<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class StudentRegistrationsChart extends ChartWidget
{
    protected static ?string $heading = 'Student Registrations';
    protected static ?string $pollingInterval = '60s';
    protected static ?int $sort = 2;
    protected static ?string $description = 'Monthly student registration trends for this year';

    protected function getData(): array
    {
        $data = Student::select(
            DB::raw('MONTH(register_date) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('register_date', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Initialize array with 12 months
        $monthsData = array_fill(1, 12, 0);

        // Fill data from database
        foreach ($data as $record) {
            $monthsData[$record->month] = $record->count;
        }

        // Month names in English
        $monthNames = [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec'
        ];

        $labels = [];
        $counts = [];

        // Prepare data for chart
        foreach ($monthsData as $month => $count) {
            $labels[] = $monthNames[$month];
            $counts[] = $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Student Registrations ' . Carbon::now()->year,
                    'data' => $counts,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
