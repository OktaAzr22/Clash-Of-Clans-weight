<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownHallTemplateBuilding extends Model
{
    protected $fillable = [
        'town_hall_template_id',
        'building_id',
        'slot',
        'level',
    ];

    public function template()
    {
        return $this->belongsTo(
            TownHallTemplate::class,
            'town_hall_template_id'
        );
    }

    public function building()
    {
        return $this->belongsTo(Building::class);
    }
}
