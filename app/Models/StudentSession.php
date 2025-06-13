<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentSession extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'student_id',
        'session_id',
        'instructor_id',
        'scheduled_date',
        'status',
        'notes',
        'score',
        'grade',
        'instructor_feedback',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scheduled_date' => 'datetime',
    ];

    /**
     * Get the student that owns the student session.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the session that owns the student session.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(Session::class);
    }

    /**
     * Get the instructor for this specific student session.
     * This allows each student session to have a different instructor
     * even if they are in the same session template.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }
}