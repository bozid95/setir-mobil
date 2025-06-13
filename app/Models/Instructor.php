<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
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
        'license_number',
        'license_expiry',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'license_expiry' => 'date',
        'is_active' => 'boolean',
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
     * Get the students for the instructor.
     * Note: Now gets students through sessions
     */
    public function students()
    {
        return $this->hasManyThrough(
            Student::class,
            Session::class,
            'instructor_id', // Foreign key on sessions table
            'id', // Foreign key on students table (through student_sessions)
            'id', // Local key on instructors table
            'id' // Local key on sessions table
        )->distinct();
    }

    /**
     * Get the sessions for the instructor.
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * Get the student sessions directly assigned to this instructor.
     * This is for the dynamic instructor assignment feature.
     */
    public function studentSessions()
    {
        return $this->hasMany(StudentSession::class);
    }
}
