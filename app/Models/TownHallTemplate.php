<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TownHallTemplate extends Model
{
    protected $fillable = [
        'town_hall',
        'name',
        'description',
    ];

    public function buildings()
{
    return $this->hasMany(
        TownHallTemplateBuilding::class,
        'town_hall_template_id'
    );
}
}

