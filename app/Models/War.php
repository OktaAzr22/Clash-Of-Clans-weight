<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class War extends Model
{
    protected $fillable = [
        'clan_id',
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
        'clan_xp_earned',
    ];

    protected $casts = [
        'preparation_start_time' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function clan()
    {
        return $this->belongsTo(Clan::class);
    }

    public function members()
    {
        return $this->hasMany(WarMember::class);
    }

    public function getRemainingTimeAttribute(): ?string
{
    $now = now();

    if ($this->state === 'preparation' && $this->start_time) {
        return $this->formatRemaining($now, $this->start_time);
    }

    if ($this->state === 'inWar' && $this->end_time) {
        return $this->formatRemaining($now, $this->end_time);
    }

    if ($this->state === 'warEnded') {
        return 'War telah berakhir';
    }

    return null;
}

protected function formatRemaining(Carbon $from, Carbon $to): string
{
    if ($from->greaterThanOrEqualTo($to)) {
        return 'Kurang dari 1 menit';
    }

    $minutes = $from->diffInMinutes($to);

    $days = intdiv($minutes, 1440);
    $hours = intdiv($minutes % 1440, 60);
    $mins = $minutes % 60;

    $parts = [];

    if ($days > 0) {
        $parts[] = "{$days} hari";
    }

    if ($hours > 0) {
        $parts[] = "{$hours} jam";
    }

    if ($mins > 0) {
        $parts[] = "{$mins} menit";
    }

    return implode(' ', $parts);
}
}