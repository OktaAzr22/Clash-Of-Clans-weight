<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownHallTemplateBuilding extends Model
{
    protected $fillable = [
        'town_hall',
        'building_id',
        'slot',
        'level',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}