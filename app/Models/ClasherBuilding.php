<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClasherBuilding extends Model
{
    protected $fillable = [
        'clasher_id',
        'building_id',
        'slot',
        'level',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function clasher()
    {
        return $this->belongsTo(Clasher::class);
    }

    
}