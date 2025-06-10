<?php

namespace App\Filament\Resources\SessionResource\RelationManagers;

use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('date')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                        'missed' => 'Missed',
                    ])
                    ->required(),
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
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('assigned_instructor')
                    ->label('Assigned Instructor')
                    ->getStateUsing(function ($record) {
                        $sessionId = request()->route('record');
                        $studentSession = \App\Models\StudentSession::where('student_id', $record->id)
                            ->where('session_id', $sessionId)
                            ->with('instructor')
                            ->first();

                        return $studentSession && $studentSession->instructor
                            ? $studentSession->instructor->name
                            : 'No instructor assigned';
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.date')
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
                    ->form(fn(Tables\Actions\AttachAction $action): array => [
                        $action->getRecordSelect(),
                        Forms\Components\DateTimePicker::make('date')
                            ->required(),
                        Forms\Components\Select::make('instructor_id')
                            ->label('Assign Instructor')
                            ->relationship('instructor', 'name')
                            ->required()
                            ->preload()
                            ->helperText('Select the instructor for this specific student session')
                            ->searchable(),
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
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form(fn(Tables\Actions\EditAction $action): array => [
                        Forms\Components\DateTimePicker::make('date')
                            ->required(),
                        Forms\Components\Select::make('instructor_id')
                            ->label('Assign Instructor')
                            ->relationship('instructor', 'name')
                            ->required()
                            ->preload()
                            ->helperText('Select the instructor for this specific student session')
                            ->searchable(),
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
