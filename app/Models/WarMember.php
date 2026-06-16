<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarMember extends Model
{
    protected $fillable = [
        'war_id',
        'clasher_id',
        'player_tag',
        'name',
        'town_hall',
        'map_position',
        'attacks_used',
    ];

    public function war()
    {
        return $this->belongsTo(War::class);
    }

    
}
