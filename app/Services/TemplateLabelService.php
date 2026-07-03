<?php

namespace App\Services;

use App\Models\Clasher;
use App\Models\TownHallTemplateBuilding;

class TemplateLabelService
{
    public function analyze(Clasher $clasher): array
    {
        $template = TownHallTemplateBuilding::where(
                'town_hall',
                $clasher->town_hall
            )
            ->get()
            ->keyBy(fn ($item) =>
                $item->building_id . '_' . $item->slot
            );

        if ($template->isEmpty()) {

            return [
                'label'   => 'belum ada',
                'matched' => 0,
                'under'   => 0,
                'over'    => 0,
            ];
        }

        $playerBuildings = $clasher
            ->buildings
            ->keyBy(fn ($item) =>
                $item->building_id . '_' . $item->slot
            );

        $matched = 0;
        $under = 0;
        $over = 0;

        foreach ($template as $key => $expected) {

            $player = $playerBuildings->get($key);

            if (!$player) {

                return [
                    'label'   => 'belum ada',
                    'matched' => 0,
                    'under'   => 0,
                    'over'    => 0,
                ];
            }

            if ($player->level == $expected->level) {

                $matched++;

                continue;
            }

            if ($player->level < $expected->level) {

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

        return [
            'label'   => $label,
            'matched' => $matched,
            'under'   => $under,
            'over'    => $over,
        ];
    }
}