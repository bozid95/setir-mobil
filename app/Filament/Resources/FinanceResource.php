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
            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->maxLength(65535),
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
                ->label('Type'),
            Tables\Columns\TextColumn::make('status')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'paid' => 'success',
                    'cancelled' => 'danger',
                }),
        ])->filters([
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ]),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
