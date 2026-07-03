<?php

namespace App\Services;

use App\Models\Clasher;
use App\Models\TownHallTemplate;

class TemplateLabelService
{
    public function analyze(Clasher $clasher): array
    {
        $templates = TownHallTemplate::query()
            ->where(
                'town_hall',
                $clasher->town_hall
            )
            ->with('buildings')
            ->get();

        if ($templates->isEmpty()) {

            return [
                'label'    => 'belum ada',
                'matched'  => 0,
                'under'    => 0,
                'over'     => 0,
                'template' => null,
            ];
        }

        $playerBuildings = $clasher
            ->buildings
            ->keyBy(fn ($item) =>
                $item->building_id . '_' . $item->slot
            );

        $bestResult = null;

        foreach ($templates as $template) {

            $matched = 0;
            $under = 0;
            $over = 0;

            $templateBuildings = $template
                ->buildings
                ->keyBy(fn ($item) =>
                    $item->building_id . '_' . $item->slot
                );

            foreach (
                $templateBuildings as $key => $expected
            ) {

                $player = $playerBuildings->get($key);

                if (!$player) {
                    continue;
                }

                if (
                    $player->level ==
                    $expected->level
                ) {

                    $matched++;

                    continue;
                }

                if (
                    $player->level <
                    $expected->level
                ) {

                    $under++;

                    continue;
                }

                $over++;
            }

            $label = 'stay';

            if ($over > 0) {

                $label = 'over';

            } elseif ($under > 0) {

                $label = 'perlu up';
            }

            $result = [
                'label'    => $label,
                'matched'  => $matched,
                'under'    => $under,
                'over'     => $over,
                'template' => $template,
            ];

            /*
            |--------------------------------------------------------------------------
            | Pilih template terbaik
            |--------------------------------------------------------------------------
            |
            | Prioritas:
            | 1. matched terbesar
            | 2. under terkecil
            | 3. over terkecil
            |
            */

            if (!$bestResult) {

                $bestResult = $result;

                continue;
            }

            if (
                $result['matched']
                > $bestResult['matched']
            ) {

                $bestResult = $result;

                continue;
            }

            if (
                $result['matched']
                == $bestResult['matched']
                &&
                $result['under']
                < $bestResult['under']
            ) {

                $bestResult = $result;

                continue;
            }

            if (
                $result['matched']
                == $bestResult['matched']
                &&
                $result['under']
                == $bestResult['under']
                &&
                $result['over']
                < $bestResult['over']
            ) {

                $bestResult = $result;
            }
        }

        return $bestResult;
    }
}