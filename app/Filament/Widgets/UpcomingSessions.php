<?php

namespace App\Filament\Widgets;

use App\Models\StudentSession;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class UpcomingSessions extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Upcoming Sessions')
            ->description('Training sessions scheduled for the next 7 days')
            ->query(
                StudentSession::query()
                    ->where('date', '>=', Carbon::today())
                    ->where('date', '<=', Carbon::today()->addDays(7))
                    ->where('status', 'scheduled')
                    ->with(['student', 'session', 'student.instructor'])
                    ->orderBy('date', 'asc')
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Date & Time')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->icon('heroicon-m-calendar'),
                Tables\Columns\TextColumn::make('student.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-m-user'),
                Tables\Columns\TextColumn::make('session.title')
                    ->label('Session')
                    ->searchable()
                    ->icon('heroicon-m-academic-cap'),
                Tables\Columns\TextColumn::make('student.instructor.name')
                    ->label('Instructor')
                    ->sortable()
                    ->icon('heroicon-m-identification'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'completed',
                        'info' => 'scheduled',
                        'danger' => 'cancelled',
                        'warning' => 'missed',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view_student')
                    ->label('View Student')
                    ->url(fn(StudentSession $record): string => route('filament.admin.resources.students.edit', ['record' => $record->student_id]))
                    ->icon('heroicon-m-eye')
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('mark_completed')
                    ->label('Mark Completed')
                    ->action(function (StudentSession $record): void {
                        $record->update(['status' => 'completed']);
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-m-check-circle'),

                Tables\Actions\Action::make('mark_cancelled')
                    ->label('Mark Cancelled')
                    ->action(function (StudentSession $record): void {
                        $record->update(['status' => 'cancelled']);
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-m-x-circle'),
            ])
            ->emptyStateHeading('No upcoming sessions')
            ->emptyStateDescription('There are no training sessions scheduled for the next 7 days.')
            ->emptyStateIcon('heroicon-o-calendar');
    }
}
