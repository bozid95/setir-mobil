<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meet extends Model
{
    //

    // add fillable
    protected $fillable = [
        'name',
        'description',
    ];
    // add guaded
    protected $guarded = ['id'];
    // add hidden
    protected $hidden = ['created_at', 'updated_at'];
}
