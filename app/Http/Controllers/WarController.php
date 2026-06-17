<?php

namespace App\Http\Controllers;

use App\Jobs\SyncCurrentWarsJob;
use App\Models\Clan;
use Carbon\Carbon;

class WarController extends Controller
{

    public function index()
    {
        $clans = Clan::with([
                'wars' => fn ($q) => $q->latest('start_time')
            ])
            ->where('is_active', true)
            ->get();

        foreach ($clans as $clan) {

            $war = $clan->wars->first();

            if (! $war) {
                continue;
            }

            $war->remaining_time = null;

            if ($war->state === 'warEnded') {

                $war->remaining_time = 'Selesai';

            } elseif ($war->end_time) {

                $seconds = now()->diffInSeconds(
                    Carbon::parse($war->end_time),
                    false
                );

                if ($seconds > 0) {

                    $hours = floor($seconds / 3600);
                    $minutes = floor(($seconds % 3600) / 60);

                    $war->remaining_time =
                        "{$hours}j {$minutes}m";

                } else {

                    $war->remaining_time = 'Selesai';
                }
            }
        }

        return view(
            'wars.index',
            compact('clans')
        );
    }

    public function show(\App\Models\War $war)
    {
        $war->load([
            'clan',
            'members' => function ($query) {
                $query->orderBy('map_position');
            }
        ]);

        return view('wars.show', compact('war'));
    }

}