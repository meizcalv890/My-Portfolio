<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'headline',
        'availability',
        'about',
        'photo',
        'cv',
        'email',
        'github',
        'linkedin',
        'instagram',
    ];

    public static function current(): self
    {
        return static::first() ?? static::create([]);
    }
}
