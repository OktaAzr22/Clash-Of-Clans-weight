<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Clasher;
use App\Models\ThBuilding;
use Illuminate\Http\Request;

class ThBuildingController extends Controller
{
    public function index()
    {
        $thBuildings = ThBuilding::with('building')
            ->orderBy('town_hall')
            ->orderBy('building_id')
            ->get();

        $buildings = Building::orderBy('name')
            ->get();

        return view(
            'th-buildings.index',
            compact(
                'thBuildings',
                'buildings'
            )
        );
    }

    public function create()
    {
        $buildings = Building::orderBy('name')
            ->get();

        return view(
            'th-buildings.create',
            compact('buildings')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'town_hall' => [
                'required',
                'integer',
                'min:1',
                'max:17',
            ],

            'building_id' => [
                'required',
                'exists:buildings,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'max_level' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        ThBuilding::updateOrCreate(
            [
                'town_hall' => $request->town_hall,
                'building_id' => $request->building_id,
            ],
            [
                'quantity' => $request->quantity,
                'max_level' => $request->max_level,
            ]
        );

        return redirect('/th-buildings')
            ->with(
                'success',
                'Konfigurasi TH berhasil disimpan.'
            );
    }

    public function edit(ThBuilding $thBuilding)
    {
        $buildings = Building::orderBy('name')->get();

        if (request()->ajax()) {
            return response()->json([
                'thBuilding' => $thBuilding,
                'buildings' => $buildings,
            ]);
        }

        return view('th-buildings.edit', compact('thBuilding', 'buildings'));
    }

    public function update(Request $request, ThBuilding $thBuilding)
{
    $request->validate([
        'town_hall' => ['required', 'integer'],
        'building_id' => ['required', 'exists:buildings,id'],
        'quantity' => ['required', 'integer', 'min:1'],
        'max_level' => ['required', 'integer', 'min:1'],
    ]);

    $thBuilding->update([
        'quantity' => $request->quantity,
        'max_level' => $request->max_level,
    ]);

    return redirect('/th-buildings')
        ->with('success', "Level {$thBuilding->building->name} untuk TH {$thBuilding->town_hall} berhasil diperbarui.");
}

    
}