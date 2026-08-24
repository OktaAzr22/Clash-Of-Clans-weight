<?php

namespace App\Console\Commands;

use App\Models\Clan;
use App\Models\War;
use App\Models\WarMember;
use App\Services\ClashOfClansService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SyncCurrentWars extends Command
{
    protected $signature = 'coc:sync-current-wars';

    protected $description = 'Sinkronisasi current war semua clan aktif';

    public function handle(
        ClashOfClansService $coc
    ): int {

        $clans = Clan::where('is_active', true)->get();

        foreach ($clans as $clan) {

            try {

                $warData = $coc->getCurrentWar($clan->tag);
                

                /*
                |--------------------------------------------------------------------------
                | Tidak sedang war
                |--------------------------------------------------------------------------
                */

                if (! $warData) {

                    $this->info(
                        "{$clan->name}: tidak sedang war."
                    );

                    continue;
                }

                if (
                    ! isset($warData['startTime']) ||
                    ($warData['state'] ?? null) === 'notInWar'
                ) {

                    $this->info(
                        "{$clan->name}: tidak sedang war."
                    );

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Simpan War
                |--------------------------------------------------------------------------
                */

                $war = War::updateOrCreate(
                    [
                        'clan_id' => $clan->id,

                        'start_time' => $this->parseTime(
                            $warData['startTime']
                        ),
                    ],
                    [
                        'opponent_tag' =>
                            $warData['opponent']['tag'] ?? null,

                        'opponent_name' =>
                            $warData['opponent']['name'] ?? 'Unknown',

                        'state' =>
                            $warData['state'] ?? null,

                        'team_size' =>
                            $warData['teamSize'] ?? 0,

                        'attacks_per_member' =>
                            $warData['attacksPerMember'] ?? 0,

                        'clan_stars' =>
                            $warData['clan']['stars'] ?? 0,

                        'opponent_stars' =>
                            $warData['opponent']['stars'] ?? 0,

                        'clan_destruction' =>
                            $warData['clan']['destructionPercentage'] ?? 0,

                        'opponent_destruction' =>
                            $warData['opponent']['destructionPercentage'] ?? 0,

                        'clan_xp_earned' =>
                            $warData['clan']['expEarned'] ?? 0,

                        'preparation_start_time' =>
                            isset($warData['preparationStartTime'])
                                ? $this->parseTime(
                                    $warData['preparationStartTime']
                                )
                                : null,

                        'end_time' =>
                            isset($warData['endTime'])
                                ? $this->parseTime(
                                    $warData['endTime']
                                )
                                : null,
                    ]
                );

                /*
                |--------------------------------------------------------------------------
                | Simpan Member War
                |--------------------------------------------------------------------------
                */

                foreach (
                    $warData['clan']['members'] ?? []
                    as $member
                ) {

                    WarMember::updateOrCreate(
                        [
                            'war_id' => $war->id,

                            'player_tag' =>
                                $member['tag'],
                        ],
                        [
                            'name' =>
                                $member['name'],

                            'town_hall' =>
                                $member['townhallLevel'] ?? 0,

                            'map_position' =>
                                $member['mapPosition'] ?? 0,

                            'attacks_used' =>
                                count(
                                    $member['attacks'] ?? []
                                ),
                        ]
                    );
                }

                $this->info(
                    "{$clan->name}: berhasil disinkronkan."
                );

            } catch (\Throwable $e) {

                $this->error(
                    "{$clan->name}: {$e->getMessage()}"
                );
            }
        }

        return self::SUCCESS;
    }

    protected function parseTime(
        string $time
    ): Carbon {

        return Carbon::createFromFormat(
            'Ymd\THis.v\Z',
            $time,
            'UTC'
        );
    }
}
