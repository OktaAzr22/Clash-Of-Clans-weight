<?php

namespace App\Services;

use App\Models\Clasher;
use App\Models\TownHallTemplate;

class TemplateLabelService
{
    public function analyze(Clasher $clasher): array
    {
        $templates = TownHallTemplate::query()
            ->where('town_hall', $clasher->town_hall)
            ->with('buildings.building')
            ->get();

        if ($templates->isEmpty()) {
            return [
                'label' => null,
                'matched' => 0,
                'under' => 0,
                'over' => 0,
                'ready' => false,
                'template' => null,
                'needs_upgrade' => [],
            ];
        }

        $playerBuildings = $clasher->buildings
            ->keyBy(fn ($item) =>
                $item->building_id . '_' . $item->slot
            );

        /*
        |--------------------------------------------------------------------------
        | CARI TEMPLATE BERDASARKAN PRIORITY BUILDING
        |--------------------------------------------------------------------------
        |
        | Priority building adalah penentu template/group.
        | Non-priority TIDAK ikut menentukan template.
        |
        */

        $bestTemplate = null;
        $bestPriorityMatched = -1;
        $bestPriorityUnder = PHP_INT_MAX;
        $bestPriorityOver = PHP_INT_MAX;

        foreach ($templates as $template) {

            $priorityMatched = 0;
            $priorityUnder = 0;
            $priorityOver = 0;

            foreach ($template->buildings as $expected) {

                /*
                 * Hanya priority building
                 * yang digunakan untuk memilih template.
                 */
                if (!$expected->building?->is_priority) {
                    continue;
                }

                $key = $expected->building_id . '_' . $expected->slot;

                $player = $playerBuildings->get($key);

                /*
                 * Kalau akun belum mempunyai data building,
                 * jangan dianggap match.
                 */
                if (!$player) {
                    $priorityUnder++;
                    continue;
                }

                if ($player->level == $expected->level) {

                    $priorityMatched++;

                } elseif ($player->level < $expected->level) {

                    $priorityUnder++;

                } else {

                    $priorityOver++;
                }
            }

            /*
             * Template terbaik:
             *
             * 1. Priority yang match paling banyak
             * 2. Priority yang under paling sedikit
             * 3. Priority yang over paling sedikit
             */

            if (
                $priorityMatched > $bestPriorityMatched
                ||
                (
                    $priorityMatched == $bestPriorityMatched
                    &&
                    $priorityUnder < $bestPriorityUnder
                )
                ||
                (
                    $priorityMatched == $bestPriorityMatched
                    &&
                    $priorityUnder == $bestPriorityUnder
                    &&
                    $priorityOver < $bestPriorityOver
                )
            ) {
                $bestTemplate = $template;
                $bestPriorityMatched = $priorityMatched;
                $bestPriorityUnder = $priorityUnder;
                $bestPriorityOver = $priorityOver;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SETELAH TEMPLATE DITEMUKAN
        |--------------------------------------------------------------------------
        |
        | Sekarang baru kita cek SEMUA building:
        |
        | Priority + Non Priority
        |
        | Ini menentukan:
        |
        | - matched
        | - under
        | - over
        | - ready
        | - needs_upgrade
        |
        */

        $matched = 0;
        $under = 0;
        $over = 0;

        $needsUpgrade = [];

        /*
         * Default READY.
         *
         * Kalau ada satu saja building berbeda,
         * READY menjadi false.
         */
        $ready = true;

        foreach ($bestTemplate->buildings as $expected) {

            $key = $expected->building_id . '_' . $expected->slot;

            $player = $playerBuildings->get($key);

            /*
             * Building belum diisi.
             *
             * Belum bisa dianggap sama.
             */
            if (!$player) {

                $ready = false;

                continue;
            }

            /*
             * SAMA
             */
            if ($player->level == $expected->level) {

                $matched++;

                continue;
            }

            /*
             * PLAYER DI BAWAH TEMPLATE
             */
            if ($player->level < $expected->level) {

                $under++;

                $ready = false;

                $needsUpgrade[] = [
                    'building_id' =>
                        $expected->building_id,

                    'building_name' =>
                        $expected->building->name ?? '-',

                    'slot' =>
                        $expected->slot,

                    'current_level' =>
                        $player->level,

                    'expected_level' =>
                        $expected->level,

                    'difference' =>
                        $expected->level - $player->level,

                    'is_priority' =>
                        (bool) ($expected->building?->is_priority ?? false),
                ];

                continue;
            }

            /*
             * PLAYER DI ATAS TEMPLATE
             */
            if ($player->level > $expected->level) {

                $over++;

                $ready = false;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | LABEL
        |--------------------------------------------------------------------------
        */

        $label = 'stay';

        if ($over > 0) {

            $label = 'over';

        } elseif ($under > 0) {

            $label = 'perlu up';
        }

        return [
            'label' =>
                $label,

            'matched' =>
                $matched,

            'under' =>
                $under,

            'over' =>
                $over,

            'ready' =>
                $ready,

            'template' =>
                $bestTemplate,

            'needs_upgrade' =>
                $needsUpgrade,
        ];
    }
}