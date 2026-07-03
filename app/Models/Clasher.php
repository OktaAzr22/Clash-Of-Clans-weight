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
        'is_ready_war',
        'label',
        'town_hall_template_id',
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

    public function warMembers()
    {
        return $this->hasMany(WarMember::class);
    }

    public function template()
    {
        return $this->belongsTo(
            TownHallTemplate::class,
            'town_hall_template_id'
        );
    }

}