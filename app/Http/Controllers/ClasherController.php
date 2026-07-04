<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use App\Models\ClasherBuilding;
use App\Models\ThBuilding;
use App\Services\ClashOfClansService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\TemplateLabelService;

class ClasherController extends Controller
{
    
public function index(Request $request)
{
    $status = $request->status ?? 'all';
    $search = $request->search;

    $query = Clasher::query()
        ->with([
            'template',
        ])
        ->withCount('clasherBuildings');

    if ($status === 'filled') {
        $query->has('clasherBuildings');
    }

    if ($status === 'empty') {
        $query->doesntHave('clasherBuildings');
    }

    if ($search) {
        $query->where(
            'name',
            'like',
            "%{$search}%"
        );
    }

    $clashers = $query
        ->latest()
        ->paginate(7)
        ->withQueryString();

    return view('clashers.index', compact(
        'clashers',
        'status',
        'search'
    ));
}



    public function store(Request $request,ClashOfClansService $coc) 
    {
        $request->validate([
            'tag' => ['required', 'string'],
        ]);

        try {

            $data = $coc->getPlayer($request->tag);

        } catch (\Exception $e) {

            return back()
                ->withErrors([
                    'tag' => $e->getMessage(),
                ])
                ->withInput();

        }

        $heroes = collect($data['heroes'] ?? []);

        Clasher::updateOrCreate(
            [
                'tag' => $data['tag'],
            ],
            [
                'name' => $data['name'],

                'clan_name' => $data['clan']['name'] ?? null,
                'clan_tag' => $data['clan']['tag'] ?? null,

                'town_hall' => $data['townHallLevel'],

                'war_stars' => $data['warStars'] ?? 0,
                'exp_level' => $data['expLevel'] ?? 0,

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

        return redirect()
            ->route('clashers.index')
            ->with(
                'success',
                'Clasher berhasil disimpan.'
            );
    }

    public function warProfile(Clasher $clasher)
    {
        $buildings = ThBuilding::with('building')
            ->where('town_hall', '<=', $clasher->town_hall)
            ->orderBy('town_hall')
            ->get()
            ->groupBy('building_id')
            ->map(fn ($items) => $items->last());

        $existingLevels = ClasherBuilding::where(
                'clasher_id',
                $clasher->id
            )
            ->get()
            ->keyBy(fn ($item) =>
                $item->building_id . '_' . $item->slot
            );

        if (request()->ajax()) {

            return view(
                'clashers.partials.war-profile-form',
                compact(
                    'clasher',
                    'buildings',
                    'existingLevels'
                )
            );
        }

        return view(
            'clashers.war-profile',
            compact(
                'clasher',
                'buildings',
                'existingLevels'
            )
        );
    }

    
    public function saveWarProfile(Request $request,Clasher $clasher,TemplateLabelService $templateLabelService) 
    {

        foreach ($request->levels ?? [] as $buildingId => $slots) {

            foreach ($slots as $slot => $level) {

                ClasherBuilding::updateOrCreate(
                    [
                        'clasher_id' => $clasher->id,
                        'building_id' => $buildingId,
                        'slot' => $slot,
                    ],
                    [
                        'level' => $level,
                    ]
                );

            }

        }

        $result = $templateLabelService->analyze(
            $clasher->fresh('buildings')
        );

  
        $clasher->update([
            'label' => $result['label'],

            'town_hall_template_id'
                => $result['template']?->id,

            'last_war_profile_update'
                => now(),
        ]);

        return redirect('/clashers')
            ->with(
                'success',
                'Data bangunan berhasil disimpan.'
            );
    }



    public function overview(Request $request)
    {
        $selectedTh = $request->th ?? 'all';

        $query = Clasher::with(['clasherBuildings.building'])
            ->has('clasherBuildings');

        if ($selectedTh !== 'all') {
            $query->where('town_hall', $selectedTh);
        }

        $clashers = $query->get();

        $clashers->each(function ($clasher) {
            $clasher->total_level = $clasher->clasherBuildings->sum('level');
        });

        if ($selectedTh !== 'all') {
            $clashers = $clashers->sortBy('total_level')->values();
        } else {
            $clashers = $clashers->sortBy([
                ['town_hall', 'desc'],
                ['total_level', 'asc'],
            ])->values();
        }

        $townHalls = Clasher::select('town_hall')
            ->distinct()
            ->orderByDesc('town_hall')
            ->pluck('town_hall');
        
        

        // ✅ AJAX RESPONSE
        if ($request->ajax()) {
            return view('clashers.partials.overview-list', compact('clashers'))->render();
        }

        return view('clashers.overview', compact(
            'clashers',
            'townHalls',
            'selectedTh'
        ));
    }

    public function syncLabels(
TemplateLabelService $templateLabelService
) {

$clashers = Clasher::with('buildings')
    ->has('clasherBuildings')
    ->get();

$updated = 0;

foreach ($clashers as $clasher) {

    $result = $templateLabelService->analyze($clasher);

    $clasher->update([
        'label' => $result['label'],

        'town_hall_template_id'
            => $result['template']?->id,

        'last_war_profile_update'
            => now(),
    ]);

    $updated++;
}

return redirect()
    ->route('clashers.index')
    ->with(
        'success',
        "{$updated} label clasher berhasil disinkronkan."
    );
}


}