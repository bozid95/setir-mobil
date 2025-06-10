<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Finance;

class FinancesRelationManager extends RelationManager
{
    protected static string $relationship = 'finances';

    protected static ?string $title = 'Payments';

    protected static ?string $modelLabel = 'Payment';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\DatePicker::make('date')
                            ->label('Date')
                            ->required()
                            ->default(now())
                            ->native(false),
                        Forms\Components\Select::make('type')
                            ->label('Payment Type')
                            ->options([
                                'tuition' => 'Tuition Fee',
                                'registration' => 'Registration Fee',
                                'material' => 'Material Fee',
                                'exam' => 'Exam Fee',
                                'certificate' => 'Certificate Fee',
                                'penalty' => 'Penalty',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('amount')
                            ->label('Payment Amount')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\DatePicker::make('due_date')
                            ->label('Due Date')
                            ->required()
                            ->native(false)
                            ->default(now()),
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending Payment',
                                'paid' => 'Fully Paid',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->defaultSort('date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Date')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'tuition' => 'Tuition Fee',
                        'registration' => 'Registration Fee',
                        'material' => 'Material Fee',
                        'exam' => 'Exam Fee',
                        'certificate' => 'Certificate Fee',
                        'penalty' => 'Penalty',
                        default => $state,
                    })
                    ->colors([
                        'success' => 'tuition',
                        'info' => 'registration',
                        'warning' => 'material',
                        'primary' => 'exam',
                        'secondary' => 'certificate',
                        'danger' => 'penalty',
                    ]),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date('d M Y')
                    ->sortable()
                    ->color(
                        fn($record): string =>
                        $record->due_date && $record->due_date < now() && $record->status === 'pending' ? 'danger' : 'primary'
                    ),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                        default => $state,
                    })
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Payment Date')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Not paid yet')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending Payment',
                        'paid' => 'Fully Paid',
                        'cancelled' => 'Cancelled',
                    ]),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Payment Category')
                    ->options([
                        'tuition' => 'Tuition Fee',
                        'registration' => 'Registration Fee',
                        'material' => 'Material Fee',
                        'exam' => 'Exam Fee',
                        'certificate' => 'Certificate Fee',
                        'penalty' => 'Penalty',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add New Payment')
                    ->icon('heroicon-o-plus-circle')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['student_id'] = $this->ownerRecord->id;
                        return $data;
                    })
                    ->successNotificationTitle('Payment created successfully'),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_as_paid')
                    ->label('Mark as Paid')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record): bool => $record->status === 'pending')
                    ->action(function ($record): void {
                        $record->update([
                            'status' => 'paid',
                            'payment_date' => now(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Payment marked as paid')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Mark Payment as Paid')
                    ->modalDescription('Are you sure you want to mark this payment as paid?'),

                Tables\Actions\EditAction::make()
                    ->label('Edit'),

                Tables\Actions\DeleteAction::make()
                    ->label('Delete'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No Payments Yet')
            ->emptyStateDescription('Start by adding the first payment for this student.')
            ->emptyStateIcon('heroicon-o-banknotes');
    }
}
