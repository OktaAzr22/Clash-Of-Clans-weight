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

        // tambahkan ini
        $totalGroups = 0;
        $totalAccounts = 0;
        $average = 0;


        if ($request->filled('th')) {

            $players = Clasher::with('buildings')
                ->where('town_hall', $request->th)
                ->get();


            $groups = $players

                ->groupBy(fn ($player) => $this->signature($player))

                // ->filter(fn($g) => $g->count() > 1)

                ->sortByDesc(fn($g) => $g->count())

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

            ->groupBy('building_name')

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
}