<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use App\Models\ThBuilding;
use App\Models\TownHallTemplateBuilding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TownHallTemplateController extends Controller
{
    public function index()
    {
        $templates = TownHallTemplateBuilding::query()
            ->selectRaw('
                town_hall,
                COUNT(*) as total_buildings,
                MAX(updated_at) as updated_at
            ')
            ->groupBy('town_hall')
            ->get()
            ->keyBy('town_hall');

        $townHalls = Clasher::query()
            ->select('town_hall')
            ->distinct()
            ->orderByDesc('town_hall')
            ->pluck('town_hall')
            ->map(function ($th) use ($templates) {

                $template = $templates->get($th);

                return [
                    'town_hall'       => $th,
                    'has_template'    => $template !== null,
                    'total_buildings' => $template?->total_buildings,
                    'updated_at'      => $template?->updated_at,
                ];
            });

        return view(
            'town-hall-templates.index',
            compact('townHalls')
        );
    }

    public function create(int $townHall)
    {
        $buildings = $this->getBuildingsForTownHall($townHall);

        if ($buildings->isEmpty()) {
            return redirect()
                ->route('town-hall-templates.index')
                ->with(
                    'error',
                    'Konfigurasi TH belum tersedia.'
                );
        }

        return view(
            'town-hall-templates.form',
            [
                'townHall'       => $townHall,
                'buildings'      => $buildings,
                'existingLevels' => collect(),
                'isEdit'         => false,
            ]
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'town_hall' => [
                'required',
                'integer',
                'min:1',
                'max:17',
            ],

            'levels' => [
                'required',
                'array',
            ],

            'levels.*' => [
                'array',
            ],

            'levels.*.*' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $this->saveTemplate(
            $validated['town_hall'],
            $validated['levels']
        );

        return redirect()
            ->route('town-hall-templates.index')
            ->with(
                'success',
                'Template berhasil disimpan.'
            );
    }

    public function edit(int $townHall)
    {
        $buildings = $this->getBuildingsForTownHall($townHall);

        if ($buildings->isEmpty()) {
            return redirect()
                ->route('town-hall-templates.index')
                ->with(
                    'error',
                    'Konfigurasi TH belum tersedia.'
                );
        }

        $existingLevels = TownHallTemplateBuilding::where(
                'town_hall',
                $townHall
            )
            ->get()
            ->keyBy(fn ($item) => $item->building_id . '_' . $item->slot);

        return view(
            'town-hall-templates.form',
            [
                'townHall'       => $townHall,
                'buildings'      => $buildings,
                'existingLevels' => $existingLevels,
                'isEdit'         => true,
            ]
        );
    }

    public function update(Request $request, int $townHall)
    {
        $validated = $request->validate([
            'levels' => [
                'required',
                'array',
            ],

            'levels.*' => [
                'array',
            ],

            'levels.*.*' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $this->saveTemplate(
            $townHall,
            $validated['levels']
        );

        return redirect()
            ->route('town-hall-templates.index')
            ->with(
                'success',
                'Template berhasil diperbarui.'
            );
    }

    /**
     * Mengambil konfigurasi bangunan yang berlaku pada suatu TH.
     * Jika TH16 tidak memiliki konfigurasi sendiri,
     * maka akan memakai konfigurasi terakhir dari TH sebelumnya.
     */
    private function getBuildingsForTownHall(int $townHall)
    {
        return ThBuilding::with('building')
            ->where('town_hall', '<=', $townHall)
            ->orderBy('town_hall')
            ->get()
            ->groupBy('building_id')
            ->map(fn ($items) => $items->last())
            ->sortBy(fn ($item) => $item->building->name)
            ->values();
    }

    private function saveTemplate(
        int $townHall,
        array $levels
    ): void {
        DB::transaction(function () use ($townHall, $levels) {

            TownHallTemplateBuilding::where(
                'town_hall',
                $townHall
            )->delete();

            foreach ($levels as $buildingId => $slots) {

                foreach ($slots as $slot => $level) {

                    TownHallTemplateBuilding::create([
                        'town_hall'   => $townHall,
                        'building_id' => $buildingId,
                        'slot'        => $slot,
                        'level'       => $level,
                    ]);

                }

            }

        });
    }
}