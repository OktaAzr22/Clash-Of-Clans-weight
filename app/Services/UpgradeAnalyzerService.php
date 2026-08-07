<?php

namespace App\Services;

use Illuminate\Support\Collection;

class UpgradeAnalyzerService
{
    public function analyze(Collection $clashers): Collection
    {
        $players = collect();

        foreach ($clashers as $clasher) {

            if (!$clasher->template) {
                continue;
            }

            $upgrades = collect();

            foreach ($clasher->template->buildings as $templateBuilding) {

                $current = $clasher->buildings->first(function ($building) use ($templateBuilding) {

                    return $building->building_id == $templateBuilding->building_id
                        && $building->slot == $templateBuilding->slot;
                });

                if (!$current) {
                    continue;
                }

                if ($current->level < $templateBuilding->level) {

                    $upgrades->push([
                        'building'   => $templateBuilding->building->name,
                        'slot'       => $templateBuilding->slot,
                        'current'    => $current->level,
                        'target'     => $templateBuilding->level,
                        'difference' => $templateBuilding->level - $current->level,
                    ]);
                }
            }

            if ($upgrades->isNotEmpty()) {

                $players->push([
                    'player'    => $clasher,
                    'upgrades'  => $upgrades,
                ]);
            }
        }

        return $players;
    }
}