<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = [
        'name',
        'is_priority',
    ];

    protected $casts = [
        'is_priority' => 'boolean',
    ];
    
    public function townHalls()
    {
        return $this->hasMany(ThBuilding::class);
    }
}