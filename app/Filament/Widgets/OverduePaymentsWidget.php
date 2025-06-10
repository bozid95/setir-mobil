<?php

namespace App\Filament\Widgets;

use App\Models\Finance;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class OverduePaymentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Overdue Payments';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function table(Table $table): Table
    {
        return $table->query(
            Finance::query()
                ->where('status', 'pending')
                ->where('due_date', '<', now())
                ->whereNotNull('due_date')
                ->with(['student'])
                ->orderBy('due_date', 'asc')
                ->limit(5) // Show only top 5 most urgent
        )
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('IDR')
                    ->color('danger'),

                Tables\Columns\TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date('d/m/Y')
                    ->color('danger'),

                Tables\Columns\TextColumn::make('days_overdue')
                    ->label('Overdue')
                    ->getStateUsing(
                        fn(Finance $record): string =>
                        now()->diffInDays($record->due_date) . ' days'
                    )
                    ->badge()
                    ->color('danger'),
            ])
            ->paginated(false) // No pagination for cleaner look
            ->emptyStateHeading('No overdue payments')
            ->emptyStateDescription('All payments are current')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
