<?php
namespace App\Http\Controllers;

use App\Models\War;
use App\Models\WarDetail;
use Illuminate\Http\Request;

class WarController extends Controller
{
    public function store(Request $request)
    {
        $war = War::create([

    'source_clan_name' =>
        $request->source_clan_name,

    'clan_a_name' =>
        $request->clan_a_name,

    'clan_b_name' =>
        $request->clan_b_name,

    'war_size' =>
        $request->war_size,

    'winner' =>
        $request->winner,

]);

        $summaryA =
            json_decode(
                $request->summary_a,
                true
            );

        $summaryB =
            json_decode(
                $request->summary_b,
                true
            );

        $allTh = collect(
            array_merge(
                array_keys($summaryA),
                array_keys($summaryB)
            )
        )->unique();

        foreach ($allTh as $th) {

            WarDetail::create([

                'war_id' => $war->id,

                'town_hall' => $th,

                'clan_a_count' =>
                    $summaryA[$th] ?? 0,

                'clan_b_count' =>
                    $summaryB[$th] ?? 0,

            ]);

        }

        return redirect()
            ->route('wars.show', $war);
    }
}