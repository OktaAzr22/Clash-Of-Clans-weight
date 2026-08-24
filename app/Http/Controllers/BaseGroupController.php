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

            $players = Clasher::query()
                ->with('buildings.building')
                ->where('town_hall', $request->input('th'))
                ->get();

            $groups = $players
                ->groupBy(fn ($player) => $this->signature($player))
                ->sortByDesc(fn ($group) => $group->count())
                ->values();

            $totalGroups = $groups->count();

            $totalAccounts = $groups->sum->count();

            $average = $totalGroups > 0
                ? round($totalAccounts / $totalGroups, 2)
                : 0;
        }

        return view('base-groups.index', [
            'ths' => $ths,
            'groups' => $groups,
            'totalGroups' => $totalGroups,
            'totalAccounts' => $totalAccounts,
            'average' => $average,
        ]);
    }

    /**
     * Membuat signature Group berdasarkan
     * building PRIORITY saja.
     */
   private function signature(Clasher $player): string
{
    return $player->buildings
        ->filter(function ($building) {
            return $building->building
                && $building->building->is_priority;
        })
        ->groupBy(
            fn ($building) => $building->building_id
        )
        ->map(
            fn ($buildings) => $buildings
                ->sortBy('slot')
                ->map(
                    fn ($building) =>
                        $building->slot . ':' . $building->level
                )
                ->implode(',')
        )
        ->sortKeys()
        ->map(
            fn ($levels, $buildingId) =>
                "{$buildingId}:{$levels}"
        )
        ->implode('|');
}

    public function warReady()
    {
        $clashers = Clasher::query()
            ->where('label', 'stay')
            ->orderByDesc('town_hall')
            ->orderBy('name')
            ->get();

        return view('base-groups.war-ready', [
            'clashers' => $clashers,
        ]);
    }

    public function updateWarReady(
        Request $request,
        Clasher $clasher
    ) {
        $validated = $request->validate([
            'status' => ['required', 'in:0,1'],
        ]);

        $clasher->update([
            'is_ready_war' => (int) $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui',
        ]);
    }
}   