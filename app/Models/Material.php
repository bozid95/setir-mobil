<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
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
     * Get the session materials for this material.
     */
    public function sessionMaterials()
    {
        return $this->hasMany(SessionMaterial::class);
    }

    /**
     * Get the sessions that use this material.
     */
    public function sessions()
    {
        return $this->belongsToMany(Session::class, 'session_materials');
    }
}
