<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use App\Models\ClasherBuilding;
use App\Models\ThBuilding;
use App\Services\ClashOfClansService;
use Illuminate\Http\Request;

class ClasherController extends Controller
{
    public function index()
    {
        $clashers = Clasher::latest()
            ->get();

        return view(
            'clashers.index',
            compact('clashers')
        );
    }

    

    public function store(
    Request $request,
    ClashOfClansService $coc
) {
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
            ->map(function ($items) {
                return $items->last();
            });

        $existingLevels = ClasherBuilding::where(
            'clasher_id',
            $clasher->id
        )
        ->get()
        ->keyBy(function ($item) {
            return $item->building_id . '_' . $item->slot;
        });

        return view(
            'clashers.war-profile',
            compact(
                'clasher',
                'buildings',
                'existingLevels'
            )
        );
    }

    public function saveWarProfile(Request $request,Clasher $clasher)
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

        $clasher->last_war_profile_update = now();
$clasher->save();

        return redirect('/clashers')
            ->with(
                'success',
                'Data bangunan berhasil disimpan.'
            );
    }

    public function overview(Request $request)
{
    $selectedTh = $request->th ?? 'all';

    $query = Clasher::with([
        'clasherBuildings.building',
    ]);

    if ($selectedTh !== 'all') {
        $query->where('town_hall', $selectedTh);
    }

    $clashers = $query->get();

    /*
    |--------------------------------------------------------------------------
    | Hitung total level bangunan
    |--------------------------------------------------------------------------
    */

    $clashers->each(function ($clasher) {

        $clasher->total_level = $clasher
            ->clasherBuildings
            ->sum('level');

    });

    /*
    |--------------------------------------------------------------------------
    | Jika memilih TH tertentu,
    | urutkan dari total level terkecil
    |--------------------------------------------------------------------------
    */

    if ($selectedTh !== 'all') {

        $clashers = $clashers
            ->sortBy('total_level')
            ->values();

    } else {

        /*
        |--------------------------------------------------------------------------
        | Semua TH:
        | TH terbesar dulu, lalu total level terkecil
        |--------------------------------------------------------------------------
        */

        $clashers = $clashers
            ->sortBy([
                ['town_hall', 'desc'],
                ['total_level', 'asc'],
            ])
            ->values();
    }

    $townHalls = Clasher::select('town_hall')
        ->distinct()
        ->orderByDesc('town_hall')
        ->pluck('town_hall');

    return view(
        'clashers.overview',
        compact(
            'clashers',
            'townHalls',
            'selectedTh'
        )
    );
}
}