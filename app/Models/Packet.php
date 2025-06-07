<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Packet extends Model
{
    //

    // add fillable
    protected $fillable = [
        'name',
        'description',
        'price',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the students for the packet.
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'packet_id');
    }
}
