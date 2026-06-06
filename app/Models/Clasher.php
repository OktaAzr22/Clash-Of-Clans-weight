<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clasher extends Model
{
    protected $fillable = [
        'tag',
        'name',
        'town_hall',
        'king',
        'queen',
        'warden',
        'champion',
    ];
}
