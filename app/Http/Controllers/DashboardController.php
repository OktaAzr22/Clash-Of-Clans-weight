<?php

namespace App\Http\Controllers;

use App\Models\Clasher;

class DashboardController extends Controller
{
    public function index()
    {

        $totalClashers = Clasher::count();

        $highestTownHall = Clasher::max('town_hall');

        $filledProfiles = Clasher::whereNotNull(
            'last_war_profile_update'
        )->count();

        $emptyProfiles = Clasher::whereNull(
            'last_war_profile_update'
        )->count();

        $townHallDistribution = Clasher::query()
            ->selectRaw('town_hall, COUNT(*) as total')
            ->groupBy('town_hall')
            ->orderByDesc('town_hall')
            ->get();

        $topProfiles = Clasher::query()
            ->with('clasherBuildings')
            ->get()
            ->map(function ($clasher) {

                $clasher->total_level =
                    $clasher->clasherBuildings->sum('level');

                return $clasher;
            })
            ->sortByDesc('total_level')
            ->take(5)
            ->values();

        $needUpdate = Clasher::query()
            ->orderByRaw(
                'last_war_profile_update IS NULL DESC'
            )
            ->orderBy('last_war_profile_update')
            ->take(5)
            ->get();

        $stayCount = Clasher::where(
            'label',
            'stay'
        )->count();

        $needUpCount = Clasher::where(
            'label',
            'perlu up'
        )->count();

        $noLabelCount = Clasher::where(
            'label',
            'belum ada'
        )->count();

        $rawLabels = Clasher::query()
            ->select([
                'name',
                'tag',
                'town_hall',
                'label',
            ])
            ->whereIn('label', [
                'stay',
                'perlu up',
                'belum ada',
            ])
            ->orderByDesc('town_hall')
            ->get()
            ->groupBy('label');

        $labels = collect([
            'stay' => $rawLabels['stay'] ?? collect(),
            'perlu up' => $rawLabels['perlu up'] ?? collect(),
            'belum ada' => $rawLabels['belum ada'] ?? collect(),
        ]);

        return view('dashboard', [
            'totalClashers' => $totalClashers,
            'highestTownHall' => $highestTownHall,
            'filledProfiles' => $filledProfiles,
            'emptyProfiles' => $emptyProfiles,
            'townHallDistribution' => $townHallDistribution,
            'topProfiles' => $topProfiles,
            'needUpdate' => $needUpdate,
            'stayCount' => $stayCount,
            'needUpCount' => $needUpCount,
            'noLabelCount' => $noLabelCount,
            'labels' => $labels,
        ]);
    }
}