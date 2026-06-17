<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clan extends Model
{
    protected $fillable = [
        'tag',
        'name',
        'is_active',
    ];

    public function wars()
    {
        return $this->hasMany(War::class);
    }

    
}