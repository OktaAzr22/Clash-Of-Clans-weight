<?php

namespace App\Services;

use App\Models\Clasher;

class ClasherSyncService
{
    public function sync(array $player): Clasher
    {
        $heroes = collect($player['heroes'] ?? []);

        return Clasher::updateOrCreate(
            [
                'tag' => $player['tag'],
            ],
            [
                'name' => $player['name'],

                'clan_name' => $player['clan']['name'] ?? null,
                'clan_tag' => $player['clan']['tag'] ?? null,

                'town_hall' => $player['townHallLevel'],

                'war_stars' => $player['warStars'] ?? 0,
                'exp_level' => $player['expLevel'] ?? 0,

                'king' => $heroes
                    ->firstWhere('name', 'Barbarian King')['level'] ?? 0,

                'queen' => $heroes
                    ->firstWhere('name', 'Archer Queen')['level'] ?? 0,

                'warden' => $heroes
                    ->firstWhere('name', 'Grand Warden')['level'] ?? 0,

                'champion' => $heroes
                    ->firstWhere('name', 'Royal Champion')['level'] ?? 0,
            ]
        );
    }
}