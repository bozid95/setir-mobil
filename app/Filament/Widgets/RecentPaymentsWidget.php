<?php

namespace App\Filament\Widgets;

use App\Models\Finance;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentPaymentsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Payments';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 5;

    public function table(Table $table): Table
    {
        return $table->query(
            Finance::query()
                ->where('status', 'paid')
                ->with(['student'])
                ->latest('payment_date')
                ->limit(10)
        )
            ->columns([
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(40),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Payment Date')
                    ->date('d/m/Y H:i')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'paid',
                        'warning' => 'pending',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'paid' => 'Paid',
                        'pending' => 'Pending',
                        default => $state,
                    }),
            ])
            ->defaultSort('payment_date', 'desc')
            ->emptyStateHeading('No payments yet')
            ->emptyStateDescription('Recent payments will appear here')
            ->emptyStateIcon('heroicon-o-currency-dollar');
    }
}
