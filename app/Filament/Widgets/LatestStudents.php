<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class LatestStudents extends Widget
{
    protected static string $view = 'filament.widgets.latest-students';
    protected static ?int $sort = 1;
    protected static ?string $pollingInterval = null;

    public function getViewData(): array
    {
        return [
            'students' => Student::with('package')
                ->latest('register_date')
                ->take(5)
                ->get(),
        ];
    }
}