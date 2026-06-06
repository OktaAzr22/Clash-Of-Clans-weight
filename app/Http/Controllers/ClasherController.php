<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use App\Services\ClashOfClansService;
use Illuminate\Http\Request;

class ClasherController extends Controller
{
    public function create()
    {
        return view('clashers.create');
    }

    public function store(
        Request $request,
        ClashOfClansService $coc
    ) {
        $data = $coc->getPlayer($request->tag);

        $heroes = collect($data['heroes'] ?? []);

        Clasher::updateOrCreate(
            ['tag' => $data['tag']],
            [
                'name' => $data['name'],
                'town_hall' => $data['townHallLevel'],

                'king' => optional(
                    $heroes->firstWhere('name', 'Barbarian King')
                )['level'] ?? 0,

                'queen' => optional(
                    $heroes->firstWhere('name', 'Archer Queen')
                )['level'] ?? 0,

                'warden' => optional(
                    $heroes->firstWhere('name', 'Grand Warden')
                )['level'] ?? 0,

                'champion' => optional(
                    $heroes->firstWhere('name', 'Royal Champion')
                )['level'] ?? 0,
            ]
        );

        return back()->with('success', 'Clasher berhasil disimpan.');
    }
}