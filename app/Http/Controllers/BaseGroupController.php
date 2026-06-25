<?php

namespace App\Http\Controllers;

use App\Models\Clasher;
use Illuminate\Http\Request;

class BaseGroupController extends Controller
{
    public function index(Request $request)
    {
        $ths = Clasher::query()
            ->distinct()
            ->orderByDesc('town_hall')
            ->pluck('town_hall');

        $groups = collect();

        $totalGroups = 0;
        $totalAccounts = 0;
        $average = 0;


        if ($request->filled('th')) {

            $players = Clasher::with([
                    'buildings.building'
                ])
                ->where('town_hall', $request->th)
                ->get();

            $groups = $players

                ->groupBy(fn ($player) => $this->signature($player))

                ->sortByDesc(fn ($g) => $g->count())

                ->values();

            $totalGroups = $groups->count();

            $totalAccounts = $groups->sum(function ($group) {
                return $group->count();
            });

            $average = $totalGroups
                ? round($totalAccounts / $totalGroups, 2)
                : 0;
        }


        return view(
            'base-groups.index',
            compact(
                'ths',
                'groups',
                'totalGroups',
                'totalAccounts',
                'average'
            )
        );
    }

    private function signature($player)
    {
        return $player->buildings

            ->groupBy(fn ($b) => $b->building->name)

            ->map(function ($buildings) {

                return $buildings

                    ->pluck('level')

                    ->sort()

                    ->implode(',');

            })

            ->sortKeys()

            ->map(fn ($levels, $name) => "$name:$levels")

            ->implode('|');
    }

    public function updateLabel(Request $request)
    {
        $request->validate([
            'label' => 'required|in:stay,perlu up,belum ada',
            'ids'   => 'required|array',
            'ids.*' => 'exists:clashers,id',
        ]);

        Clasher::whereIn('id', $request->ids)
            ->update([
                'label' => $request->label
            ]);

        return back()->with(
            'success',
            'Label berhasil diperbarui.'
        );
    }

    public function warReady()
{
    $clashers = Clasher::where('label', 'stay')
        ->orderByDesc('town_hall')
        ->orderBy('name')
        ->get();

    return view(
        'base-groups.war-ready',
        compact('clashers')
    );
}


public function updateWarReady(Request $request, Clasher $clasher)
{
    $request->validate([
        'status' => 'required|boolean'
    ]);

    $clasher->update([
        'is_ready_war' => $request->status
    ]);

    return response()->json([
        'success' => true
    ]);
}
}