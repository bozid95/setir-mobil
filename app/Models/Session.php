<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Session extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'driving_sessions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'package_id',
        'order',
        'title',
        'description',
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
     * Get the package that owns the session.
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    /**
     * Get the session materials for this session.
     */
    public function sessionMaterials(): HasMany
    {
        return $this->hasMany(SessionMaterial::class);
    }

    /**
     * Get the materials for this session.
     */
    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class, 'session_materials');
    }

    /**
     * Get the student sessions for this session.
     */
    public function studentSessions(): HasMany
    {
        return $this->hasMany(StudentSession::class);
    }

    /**
     * Get the students for this session.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_sessions')
            ->withPivot(['date', 'status', 'notes'])
            ->withTimestamps();
    }
}
