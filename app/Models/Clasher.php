<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasher extends Model
{
    protected $fillable = [
        'tag',
        'name',

        'clan_name',
        'clan_tag',

        'town_hall',
        'war_stars',
        'exp_level',

        'king',
        'queen',
        'warden',
        'champion',

        'last_war_profile_update',
    ];

    protected $casts = [
        'last_war_profile_update' => 'datetime',
    ];

    public function buildings()
    {
        return $this->hasMany(ClasherBuilding::class);
    }

    public function clasherBuildings()
    {
        return $this->hasMany(ClasherBuilding::class);
    }
}