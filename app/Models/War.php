<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class War extends Model
{
    protected $fillable = [
        'clan_tag',
        'clan_name',
        'opponent_tag',
        'opponent_name',
        'state',
        'team_size',
        'attacks_per_member',
        'clan_stars',
        'opponent_stars',
        'clan_destruction',
        'opponent_destruction',
        'preparation_start_time',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'preparation_start_time' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function members()
    {
        return $this->hasMany(WarMember::class);
    }

    public function clan()
    {
        return $this->belongsTo(Clan::class);
    }
}
