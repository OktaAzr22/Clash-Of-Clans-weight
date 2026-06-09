<?php

namespace App\Http\Controllers;

use App\Services\ClashOfClansService;
use Illuminate\Http\Request;

class ClanController extends Controller
{
    public function search()
    {
        return view('clans.search');
    }

    public function result(
        Request $request,
        ClashOfClansService $coc
    )
    {
        $clan = $coc->getClan(
            $request->clan_tag
        );

        if (!isset($clan['tag'])) {

            return back()->with(
                'error',
                'Clan tidak ditemukan.'
            );

        }

        $members = collect(
            $clan['memberList'] ?? []
        )->sortByDesc(
            'townHallLevel'
        );

        $thSummary = $members
            ->groupBy('townHallLevel')
            ->map(fn($group) => $group->count())
            ->sortKeysDesc();

        return view(
            'clans.result',
            compact(
                'clan',
                'members',
                'thSummary'
            )
        );
    }

    public function analyze(
        Request $request,
        ClashOfClansService $coc
    )
    {
        $clan = $coc->getClan(
            $request->clan_tag
        );

        $members = collect(
            $clan['memberList'] ?? []
        )->sortByDesc('townHallLevel');

        $totalMembers = $members->count();

        $warSizes = collect([
    5,
    10,
    15,
    20,
    25,
    30,
    40,
    50
])->filter(function ($size) use ($totalMembers) {

    return ($size * 2) <= $totalMembers;

});

        $thSummary = $members
            ->groupBy('townHallLevel')
            ->map(fn ($group) => $group->count())
            ->sortKeysDesc();

        $splitSuggestion = [];

        foreach ($thSummary as $th => $count) {

            $splitSuggestion[$th] = [

                'clan_a' => floor($count / 2),

                'clan_b' => ceil($count / 2),

            ];

        }

        return view(
            'clans.analyze',
            compact(
                'clan',
                'totalMembers',
                'warSizes',
                'thSummary',
                'splitSuggestion'
            )
        );
    }

    public function generate(
    Request $request,
    ClashOfClansService $coc
)
{
    $clan = $coc->getClan(
        $request->clan_tag
    );

    $warSize = (int) $request->war_size;

    $members = collect(
        $clan['memberList'] ?? []
    )
    ->sortByDesc('townHallLevel')
    ->take($warSize * 2)
    ->values();

    /*
    |--------------------------------------------------------------------------
    | Bagi roster menjadi 2 clan
    |--------------------------------------------------------------------------
    */

    $clanA = collect();

    $clanB = collect();

    foreach ($members as $index => $member) {

        if ($index % 2 == 0) {

            $clanA->push($member);

        } else {

            $clanB->push($member);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Ringkasan TH Clan A
    |--------------------------------------------------------------------------
    */

    $summaryA = $clanA
        ->groupBy('townHallLevel')
        ->map(fn ($group) => $group->count())
        ->sortKeysDesc();

    /*
    |--------------------------------------------------------------------------
    | Ringkasan TH Clan B
    |--------------------------------------------------------------------------
    */

    $summaryB = $clanB
        ->groupBy('townHallLevel')
        ->map(fn ($group) => $group->count())
        ->sortKeysDesc();

    return view(
        'clans.generate',
        compact(
            'clan',
            'warSize',
            'clanA',
            'clanB',
            'summaryA',
            'summaryB'
        )
    );
}
}
