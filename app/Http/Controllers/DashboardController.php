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

        $townHallDistribution = Clasher::selectRaw(
                'town_hall, COUNT(*) as total'
            )
            ->groupBy('town_hall')
            ->orderByDesc('town_hall')
            ->get();

        $topProfiles = Clasher::with('clasherBuildings')
            ->get()
            ->map(function ($clasher) {

                $clasher->total_level =
                    $clasher->clasherBuildings->sum('level');

                return $clasher;
            })
            ->sortByDesc('total_level')
            ->take(5);

        $needUpdate = Clasher::orderByRaw(
                'last_war_profile_update IS NULL DESC'
            )
            ->orderBy('last_war_profile_update')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalClashers',
            'highestTownHall',
            'filledProfiles',
            'emptyProfiles',
            'townHallDistribution',
            'topProfiles',
            'needUpdate',
        ));
    }
}