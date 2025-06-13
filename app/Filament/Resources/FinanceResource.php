<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceResource\Pages;
use App\Models\Finance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FinanceResource extends Resource
{
    protected static ?string $model = Finance::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationLabel = 'Finance Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('student_id')
                ->relationship('student', 'name')
                ->required()
                ->searchable(),
            Forms\Components\DatePicker::make('date')
                ->label('Transaction Date')
                ->required()
                ->default(now()),
            Forms\Components\TextInput::make('amount')
                ->label('Amount')
                ->required()
                ->numeric()
                ->prefix('Rp'),
            Forms\Components\Select::make('type')
                ->label('Transaction Type')
                ->options([
                    'tuition' => 'Tuition Fee',
                    'registration' => 'Registration Fee',
                    'material' => 'Material Fee',
                    'exam' => 'Exam Fee',
                ])
                ->required(),
            Forms\Components\Select::make('status')
                ->label('Payment Status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ])
                ->required()
                ->default('pending'),
            Forms\Components\DatePicker::make('due_date')
                ->label('Due Date')
                ->nullable(),
            Forms\Components\DateTimePicker::make('payment_date')
                ->label('Payment Date')
                ->nullable()
                ->displayFormat('d/m/Y H:i'),
            Forms\Components\FileUpload::make('payment_receipt')
                ->label('Payment Receipt / Proof of Payment')
                ->directory('payment-receipts')
                ->acceptedFileTypes(['image/*', 'application/pdf'])
                ->maxSize(5120) // 5MB
                ->columnSpanFull()
                ->helperText('Upload payment receipt, transfer proof, or invoice (Max 5MB). Supported formats: JPG, PNG, PDF'),
            Forms\Components\Textarea::make('receipt_notes')
                ->label('Receipt Notes')
                ->placeholder('Additional notes about the payment receipt...')
                ->maxLength(500)
                ->columnSpanFull(),
            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->maxLength(65535)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('student.name')
                ->label('Student')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('date')
                ->label('Date')
                ->date()
                ->sortable(),
            Tables\Columns\TextColumn::make('amount')
                ->label('Amount')
                ->money('IDR')
                ->sortable(),
            Tables\Columns\TextColumn::make('type')
                ->label('Type')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'tuition' => 'success',
                    'registration' => 'info',
                    'material' => 'warning',
                    'exam' => 'primary',
                    default => 'gray',
                }),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'pending' => 'warning',
                    'paid' => 'success',
                    'cancelled' => 'danger',
                }),
            Tables\Columns\IconColumn::make('payment_receipt')
                ->label('Receipt')
                ->boolean()
                ->trueIcon('heroicon-o-document-text')
                ->falseIcon('heroicon-o-x-mark')
                ->trueColor('success')
                ->falseColor('gray')
                ->tooltip(fn($record) => $record->payment_receipt ? 'Receipt uploaded' : 'No receipt'),
            Tables\Columns\TextColumn::make('due_date')
                ->label('Due Date')
                ->date()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('payment_date')
                ->label('Payment Date')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ]),
            Tables\Filters\SelectFilter::make('type')
                ->options([
                    'tuition' => 'Tuition Fee',
                    'registration' => 'Registration Fee',
                    'material' => 'Material Fee',
                    'exam' => 'Exam Fee',
                ]),
            Tables\Filters\Filter::make('has_receipt')
                ->label('Has Receipt')
                ->query(fn($query) => $query->whereNotNull('payment_receipt')),
        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
            Tables\Actions\Action::make('download_receipt')
                ->label('Download Receipt')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(fn($record) => $record->payment_receipt ? asset('storage/' . $record->payment_receipt) : null)
                ->openUrlInNewTab()
                ->visible(fn($record) => !empty($record->payment_receipt)),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFinances::route('/'),
            'create' => Pages\CreateFinance::route('/create'),
            'edit' => Pages\EditFinance::route('/{record}/edit'),
        ];
    }
}
