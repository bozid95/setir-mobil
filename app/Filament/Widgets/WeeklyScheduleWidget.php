<?php

namespace App\Filament\Widgets;

use App\Models\StudentSession;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class WeeklyScheduleWidget extends BaseWidget
{
    protected static ?string $heading = 'This Week\'s Schedule';

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                StudentSession::query()
                    ->with(['student', 'session', 'instructor'])
                    ->whereBetween('scheduled_date', [
                        now()->startOfWeek(),
                        now()->endOfWeek()
                    ])
                    ->orderBy('scheduled_date')
            )
            ->columns([
                Tables\Columns\TextColumn::make('scheduled_date')
                    ->label('Date & Time')
                    ->dateTime('D, M j - H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable(),
                Tables\Columns\TextColumn::make('session.name')
                    ->label('Session')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instructor.name')
                    ->label('Instructor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'completed' => 'success',
                        'scheduled' => 'info',
                        'cancelled' => 'danger',
                        'missed' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('notes')
                    ->limit(30)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),
            ])
            ->defaultSort('scheduled_date', 'asc')
            ->emptyStateHeading('No sessions scheduled')
            ->emptyStateDescription('There are no sessions scheduled for this week.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}