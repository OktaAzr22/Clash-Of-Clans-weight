<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarDetail extends Model
{
    protected $fillable = [
        'war_id',
        'town_hall',
        'clan_a_count',
        'clan_b_count',
    ];

    public function war()
    {
        return $this->belongsTo(War::class);
    }
}
