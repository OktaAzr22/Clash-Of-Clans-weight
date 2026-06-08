<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\ThBuilding;
use Illuminate\Http\Request;

class ThBuildingController extends Controller
{
    public function index()
    {
        $thBuildings = ThBuilding::with('building')
            ->orderBy('town_hall')
            ->get();

        return view(
            'th-buildings.index',
            compact('thBuildings')
        );
    }

    public function create()
    {
        $buildings = Building::all();

        return view(
            'th-buildings.create',
            compact('buildings')
        );
    }

    public function store(Request $request)
    {
        ThBuilding::create([
            'town_hall' => $request->town_hall,
            'building_id' => $request->building_id,
            'quantity' => $request->quantity,
        ]);

        return redirect('/th-buildings');
    }
}