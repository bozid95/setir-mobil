<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\Session;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SessionsRelationManager extends RelationManager
{
    protected static string $relationship = 'sessions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('scheduled_date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'missed' => 'Missed',
                    ])
                    ->required()
                    ->default('scheduled'),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('assigned_instructor')
                    ->label('Assigned Instructor')
                    ->getStateUsing(function ($record) {
                        $student = $this->getOwnerRecord();
                        $studentSession = \App\Models\StudentSession::where('student_id', $student->id)
                            ->where('session_id', $record->id)
                            ->with('instructor')
                            ->first();

                        return $studentSession && $studentSession->instructor
                            ? $studentSession->instructor->name
                            : 'No instructor assigned';
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.scheduled_date')
                    ->label('Date & Time')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'completed' => 'success',
                        'scheduled' => 'info',
                        'cancelled' => 'danger',
                        'missed' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('pivot.score')
                    ->label('Score')
                    ->numeric(decimalPlaces: 1)
                    ->suffix('/100')
                    ->color(fn(?float $state): string => match (true) {
                        $state >= 80 => 'success',
                        $state >= 60 => 'warning',
                        $state < 60 && $state !== null => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('pivot.grade')
                    ->label('Grade')
                    ->badge()
                    ->color(fn(?string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        'D', 'F' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('pivot.notes')
                    ->limit(30),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect()
                    ->recordSelectOptionsQuery(fn(Builder $query) => $query->orderBy('name'))
                    ->form(fn(Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\DateTimePicker::make('scheduled_date')
                            ->required(),
                        Forms\Components\Select::make('instructor_id')
                            ->label('Assign Instructor')
                            ->options(\App\Models\Instructor::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->helperText('Select the instructor for this specific student session'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'scheduled' => 'Scheduled',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'missed' => 'Missed',
                            ])
                            ->required()
                            ->default('scheduled'),
                        Forms\Components\TextInput::make('score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.1)
                            ->suffix('/100')
                            ->helperText('Enter score out of 100'),
                        Forms\Components\Select::make('grade')
                            ->options([
                                'A' => 'A (Excellent)',
                                'B' => 'B (Good)',
                                'C' => 'C (Fair)',
                                'D' => 'D (Poor)',
                                'F' => 'F (Fail)',
                            ])
                            ->helperText('Letter grade for the session'),
                        Forms\Components\Textarea::make('notes')
                            ->maxLength(65535)
                            ->helperText('General notes about the session'),
                        Forms\Components\Textarea::make('instructor_feedback')
                            ->maxLength(65535)
                            ->helperText('Instructor feedback on student performance'),
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(fn(Tables\Actions\EditAction $action): array => [
                        Forms\Components\DateTimePicker::make('scheduled_date')
                            ->required(),
                        Forms\Components\Select::make('instructor_id')
                            ->label('Assign Instructor')
                            ->options(\App\Models\Instructor::pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->helperText('Select the instructor for this specific student session'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'scheduled' => 'Scheduled',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'missed' => 'Missed',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('score')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->step(0.1)
                            ->suffix('/100'),
                        Forms\Components\Select::make('grade')
                            ->options([
                                'A' => 'A (Excellent)',
                                'B' => 'B (Good)',
                                'C' => 'C (Fair)',
                                'D' => 'D (Poor)',
                                'F' => 'F (Fail)',
                            ]),
                        Forms\Components\Textarea::make('notes')
                            ->maxLength(65535),
                        Forms\Components\Textarea::make('instructor_feedback')
                            ->maxLength(65535),
                    ]),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
