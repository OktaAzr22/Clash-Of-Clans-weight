<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use App\Models\ClasherBuilding;
use App\Models\ThBuilding;
use App\Services\ClashOfClansService;
use Illuminate\Http\Request;
use App\Services\TemplateLabelService;
use App\Services\UpgradeAnalyzerService;
use App\Jobs\SyncAllTownHallJob;
use Barryvdh\DomPDF\Facade\Pdf;

class ClasherController extends Controller
{
    
    public function index( Request $request,UpgradeAnalyzerService $upgradeAnalyzer) 
    {
        $status = $request->status ?? 'all';
        $search = $request->search;

        $query = Clasher::withTemplate();

        $query

            ->when(
                $status === 'filled',
                fn ($query) => $query->filledProfile()
            )

            ->when(
                $status === 'empty',
                fn ($query) => $query->emptyProfile()
            )

            ->when(
                $search,
                fn ($query) => $query->where(
                    'name',
                    'like',
                    "%{$search}%"
                )
            );

        $clashers = $query
            ->latest()
            ->paginate(7)
            ->withQueryString();

        $upgradeClashers = Clasher::needUpgrade()
            ->with([
                'buildings.building',
                'template.buildings.building',
            ])
            ->orderByDesc('town_hall')
            ->orderBy('name')
            ->get();

        $players = $upgradeAnalyzer->analyze($upgradeClashers);

        $totalPlayers = $players->count();

        return view(
            'clashers.index',
            compact(
                'clashers',
                'status',
                'search',
                'players',
                'totalPlayers'
            )
        );
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

            'upgrade_notes'
                => $result['needs_upgrade'],
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

    public function syncLabels(TemplateLabelService $templateLabelService) 
    {

        $clashers = Clasher::with('buildings')
            ->has('clasherBuildings')
            ->get();

        $updated = 0;

        foreach ($clashers as $clasher) {

            $result = $templateLabelService
                ->analyze($clasher);

            $clasher->update([

                'label'
                    => $result['label'],

                'upgrade_notes'
                    => $result['needs_upgrade'],

                'town_hall_template_id'
                    => $result['template']?->id,

                'last_war_profile_update'
                    => now(),
            ]);

            $updated++;
            
        }

       

            return back()->with(
                'success',
                "{$updated} clasher berhasil disinkronkan."

            );
    }

    

public function syncAllTownHall()
{
    SyncAllTownHallJob::dispatch();

    return back()->with(
        'success',
        'Sinkronisasi Town Hall sedang diproses di background.'
    );
}


public function exportPdf(Request $request)
    {
        $query = Clasher::with([
            'buildings.building',
            'template.buildings.building'
        ])
        ->where('label', 'perlu up');

        if ($request->filled('th')) {
            $query->where('town_hall', $request->th);
        }

        $clashers = $query
            ->orderByDesc('town_hall')
            ->orderBy('name')
            ->get();

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
                        'building' => $templateBuilding->building->name,
                        'slot' => $templateBuilding->slot,
                        'current' => $current->level,
                        'target' => $templateBuilding->level,
                        'difference' => $templateBuilding->level - $current->level,
                    ]);
                }
            }

            if ($upgrades->isNotEmpty()) {

                $players->push([
                    'player' => $clasher,
                    'upgrades' => $upgrades,
                ]);

            }

        }

        $pdf = Pdf::loadView('clashers.partials.pdf', [

            'players' => $players,

        ])->setPaper('a4', 'portrait');

        return $pdf->download(
            'list-upgrade-' . now()->format('Y-m-d') . '.pdf'
        );
    }
}