<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThBuilding extends Model
{
    protected $fillable = [
        'town_hall',
        'building_id',
        'quantity',
        'max_level',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}