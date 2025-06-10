<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'register_date',
        'unique_code',
        'user_id',
        'package_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'register_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if (!$student->unique_code) {
                do {
                    $uniqueCode = 'DS' . date('Y') . strtoupper(Str::random(6));
                } while (self::where('unique_code', $uniqueCode)->exists());

                $student->unique_code = $uniqueCode;
            }

            if (!$student->register_date) {
                $student->register_date = Carbon::now();
            }
        });
    }

    /**
     * Get the package that owns the student.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the student sessions for this student.
     */
    public function studentSessions(): HasMany
    {
        return $this->hasMany(StudentSession::class);
    }

    /**
     * Get the sessions for this student.
     */
    public function sessions(): BelongsToMany
    {
        return $this->belongsToMany(Session::class, 'student_sessions')
            ->withPivot(['date', 'status', 'notes', 'score', 'grade', 'instructor_feedback'])
            ->withTimestamps();
    }

    /**
     * Get the finances for this student.
     */
    public function finances(): HasMany
    {
        return $this->hasMany(Finance::class);
    }
}
