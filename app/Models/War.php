<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class War extends Model
{
    protected $fillable = [
        'source_clan_name',
        'clan_a_name',
        'clan_b_name',
        'war_size',
        'winner',
    ];

    public function details()
    {
        return $this->hasMany(WarDetail::class);
    }
}
