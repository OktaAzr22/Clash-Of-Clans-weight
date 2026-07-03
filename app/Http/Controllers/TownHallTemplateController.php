<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use App\Models\ThBuilding;
use App\Models\TownHallTemplate;
use App\Models\TownHallTemplateBuilding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TownHallTemplateController extends Controller
{
    public function index()
    {
        $templates = TownHallTemplate::query()
            ->withCount('buildings')
            ->latest()
            ->get();

        return view(
            'town-hall-templates.index',
            compact('templates')
        );
    }

    public function create()
    {
        $townHalls = Clasher::query()
            ->select('town_hall')
            ->distinct()
            ->orderByDesc('town_hall')
            ->pluck('town_hall');

        return view(
            'town-hall-templates.create',
            compact('townHalls')
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

            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $template = TownHallTemplate::create([
            'town_hall' => $validated['town_hall'],
            'name'      => $validated['name'],
        ]);

        return redirect()->route(
            'town-hall-templates.builder',
            $template
        );
    }

    public function builder(TownHallTemplate $template)
    {
        $buildings = $this->getBuildingsForTownHall(
            $template->town_hall
        );

        $existingLevels = TownHallTemplateBuilding::query()
            ->where(
                'town_hall_template_id',
                $template->id
            )
            ->get()
            ->keyBy(fn ($item) =>
                $item->building_id . '_' . $item->slot
            );

        return view(
            'town-hall-templates.form',
            [
                'template'       => $template,
                'buildings'      => $buildings,
                'existingLevels' => $existingLevels,
            ]
        );
    }

    public function update(
        Request $request,
        TownHallTemplate $template
    ) {
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
            $template,
            $validated['levels']
        );

        return redirect()
            ->route('town-hall-templates.index')
            ->with(
                'success',
                'Template berhasil disimpan.'
            );
    }

    public function destroy(
        TownHallTemplate $template
    ) {
        $template->delete();

        return redirect()
            ->route('town-hall-templates.index')
            ->with(
                'success',
                'Template berhasil dihapus.'
            );
    }

    private function getBuildingsForTownHall(
        int $townHall
    ) {
        return ThBuilding::with('building')
            ->where('town_hall', '<=', $townHall)
            ->orderBy('town_hall')
            ->get()
            ->groupBy('building_id')
            ->map(fn ($items) => $items->last())
            ->sortBy(fn ($item) =>
                $item->building->name
            )
            ->values();
    }

    private function saveTemplate(
        TownHallTemplate $template,
        array $levels
    ): void {

        DB::transaction(function () use (
            $template,
            $levels
        ) {

            TownHallTemplateBuilding::query()
                ->where(
                    'town_hall_template_id',
                    $template->id
                )
                ->delete();

            foreach ($levels as $buildingId => $slots) {

                foreach ($slots as $slot => $level) {

                    TownHallTemplateBuilding::create([
                        'town_hall_template_id'
                            => $template->id,

                        'building_id'
                            => $buildingId,

                        'slot'
                            => $slot,

                        'level'
                            => $level,
                    ]);
                }
            }
        });
    }
}