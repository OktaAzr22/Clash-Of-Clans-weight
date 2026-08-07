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
        'upgrade_notes',
    ];

    protected $casts = [
        'last_war_profile_update' => 'datetime',
        'upgrade_notes' => 'array',
    ];

    public function buildings()
    {
        return $this->hasMany(ClasherBuilding::class);
    }

    public function clasherBuildings()
    {
        return $this->hasMany(ClasherBuilding::class);
    }

    

    public function template()
    {
        return $this->belongsTo(
            TownHallTemplate::class,
            'town_hall_template_id'
        );
    }

    public function scopeWithTemplate($query)
    {
        return $query
            ->with('template')
            ->withCount('clasherBuildings');
    }

    public function scopeFilledProfile($query)
    {
        return $query->has('clasherBuildings');
    }

    public function scopeEmptyProfile($query)
    {
        return $query->doesntHave('clasherBuildings');
    }

    public function scopeNeedUpgrade($query)
    {
        return $query->where('label', 'perlu up');
    }

    public function scopeStay($query)
    {
        return $query->where('label', 'stay');
    }

}