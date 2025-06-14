<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinanceResource\Pages;
use App\Models\Finance;
use App\Exports\FinanceExport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Builder;

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
                ->sortable()
                ->summarize([
                    Tables\Columns\Summarizers\Sum::make()
                        ->money('IDR')
                        ->label('Total'),
                ]),
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
            // Date Range Filter
            Filter::make('date_range')
                ->form([
                    Forms\Components\DatePicker::make('date_from')
                        ->label('Date From'),
                    Forms\Components\DatePicker::make('date_until')
                        ->label('Date Until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['date_from'],
                            fn(Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                        )
                        ->when(
                            $data['date_until'],
                            fn(Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                        );
                }),

            Tables\Filters\SelectFilter::make('type')
                ->options([
                    'tuition' => 'Tuition Fee',
                    'registration' => 'Registration Fee',
                    'material' => 'Material Fee',
                    'exam' => 'Exam Fee',
                ])
                ->label('Payment Type'),

            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'cancelled' => 'Cancelled',
                ]),
            Tables\Filters\Filter::make('has_receipt')
                ->label('Has Receipt')
                ->query(fn($query) => $query->whereNotNull('payment_receipt')),
        ])
            ->headerActions([
                Tables\Actions\Action::make('export')
                    ->label('Export to Excel')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function ($livewire) {
                        $query = $livewire->getFilteredTableQuery();
                        $finances = $query->with('student')->get();

                        $filename = 'finance_report_' . now()->format('Y_m_d_H_i_s') . '.xlsx';

                        return Excel::download(new FinanceExport($finances), $filename);
                    }),

                Tables\Actions\Action::make('export_csv')
                    ->label('Export to CSV')
                    ->icon('heroicon-o-document-text')
                    ->color('info')
                    ->action(function ($livewire) {
                        $query = $livewire->getFilteredTableQuery();

                        return response()->streamDownload(function () use ($query) {
                            $finances = $query->with('student')->get();

                            $handle = fopen('php://output', 'w');

                            // Add BOM for UTF-8
                            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                            // CSV Headers
                            fputcsv($handle, [
                                'No',
                                'Date',
                                'Student Name',
                                'Student Code',
                                'Type',
                                'Amount',
                                'Status',
                                'Due Date',
                                'Payment Date',
                                'Description',
                                'Has Receipt'
                            ]);

                            // CSV Data
                            $no = 1;
                            foreach ($finances as $finance) {
                                fputcsv($handle, [
                                    $no++,
                                    $finance->date ? $finance->date->format('d/m/Y') : '',
                                    $finance->student ? $finance->student->name : '',
                                    $finance->student ? $finance->student->unique_code : '',
                                    ucfirst($finance->type),
                                    $finance->amount,
                                    ucfirst($finance->status),
                                    $finance->due_date ? $finance->due_date->format('d/m/Y') : '',
                                    $finance->payment_date ? $finance->payment_date->format('d/m/Y H:i') : '',
                                    $finance->description ?? '',
                                    $finance->payment_receipt ? 'Ada Bukti' : 'Belum Ada'
                                ]);
                            }

                            fclose($handle);
                        }, 'finance_report_' . now()->format('Y_m_d_H_i_s') . '.csv', [
                            'Content-Type' => 'text/csv; charset=utf-8',
                            'Content-Disposition' => 'attachment; filename="finance_report_' . now()->format('Y_m_d_H_i_s') . '.csv"',
                        ]);
                    }),
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
                    Tables\Actions\BulkAction::make('export_selected_excel')
                        ->label('Export Selected (Excel)')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('success')
                        ->action(function ($records) {
                            $filename = 'selected_finance_' . now()->format('Y_m_d_H_i_s') . '.xlsx';
                            return Excel::download(new FinanceExport($records), $filename);
                        }),

                    Tables\Actions\BulkAction::make('export_selected_csv')
                        ->label('Export Selected (CSV)')
                        ->icon('heroicon-o-document-text')
                        ->color('info')
                        ->action(function ($records) {
                            return response()->streamDownload(function () use ($records) {
                                $handle = fopen('php://output', 'w');

                                // Add BOM for UTF-8
                                fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

                                // CSV Headers
                                fputcsv($handle, [
                                    'No',
                                    'Date',
                                    'Student Name',
                                    'Student Code',
                                    'Type',
                                    'Amount',
                                    'Status',
                                    'Due Date',
                                    'Payment Date',
                                    'Description',
                                    'Has Receipt'
                                ]);

                                // CSV Data
                                $no = 1;
                                foreach ($records as $finance) {
                                    fputcsv($handle, [
                                        $no++,
                                        $finance->date ? $finance->date->format('d/m/Y') : '',
                                        $finance->student ? $finance->student->name : '',
                                        $finance->student ? $finance->student->unique_code : '',
                                        ucfirst($finance->type),
                                        $finance->amount,
                                        ucfirst($finance->status),
                                        $finance->due_date ? $finance->due_date->format('d/m/Y') : '',
                                        $finance->payment_date ? $finance->payment_date->format('d/m/Y H:i') : '',
                                        $finance->description ?? '',
                                        $finance->payment_receipt ? 'Ada Bukti' : 'Belum Ada'
                                    ]);
                                }

                                fclose($handle);
                            }, 'selected_finance_' . now()->format('Y_m_d_H_i_s') . '.csv', [
                                'Content-Type' => 'text/csv; charset=utf-8',
                                'Content-Disposition' => 'attachment; filename="selected_finance_' . now()->format('Y_m_d_H_i_s') . '.csv"',
                            ]);
                        }),
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
