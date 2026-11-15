<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name', 'level', 'icon', 'icon_slug'];

    public function getLogoUrlAttribute(): ?string
    {
        if ($this->icon) {
            return asset('storage/' . $this->icon);
        }

        if ($this->icon_slug) {
            return 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/'
                . $this->icon_slug . '/' . $this->icon_slug . '-original.svg';
        }

        return null;
    }
}
