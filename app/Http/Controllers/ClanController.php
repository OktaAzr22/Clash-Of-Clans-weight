<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Services\ClashOfClansService;
use Exception;
use Illuminate\Http\Request;
use App\Models\Clasher;

class ClanController extends Controller
{
    /**
     * Daftar clan.
     */
    public function index()
    {
        $clans = Clan::latest()->get();

        return view('clans.index', compact('clans'));
    }

    /**
     * Tambah clan berdasarkan tag CoC.
     */
    public function store(Request $request,ClashOfClansService $coc) 
    {
        $validated = $request->validate([
            'tag' => ['required', 'string'],
        ]);

        try {
            $clanData = $coc->getClan($validated['tag']);

            Clan::updateOrCreate(
                [
                    'tag' => $clanData['tag'],
                ],
                [
                    'name'      => $clanData['name'],
                    'is_active' => true,
                ]
            );

            return redirect()
                ->route('clans.index')
                ->with(
                    'success',
                    "Clan {$clanData['name']} berhasil ditambahkan."
                );

        } catch (Exception $e) {

            return back()
                ->withInput()
                ->withErrors([
                    'tag' => $e->getMessage(),
                ]);
        }
    }

    /**
     * Aktifkan / Nonaktifkan clan.
     */
    public function toggle(Clan $clan)
    {
        $clan->update([
            'is_active' => ! $clan->is_active,
        ]);

        return back()->with(
            'success',
            'Status clan berhasil diperbarui.'
        );
    }

    public function search(Request $request,ClashOfClansService $coc) 
    {
        $request->validate([
            'tag' => ['required', 'string'],
        ]);

        try {

            $clan = $coc->getClan($request->tag);

        } catch (\Exception $e) {

            return back()
                ->withErrors([
                    'tag' => $e->getMessage(),
                ])
                ->withInput();
        }

        return view(
            'clans.result',
            compact('clan')
        );
    }

    public function storeMembers(Request $request,ClashOfClansService $coc) 
    {
        $request->validate([
            'clan_tag' => ['required', 'string'],
        ]);

        try {

            $clan = $coc->getClan($request->clan_tag);

            $saved = 0;
            $failed = 0;

            foreach ($clan['memberList'] as $member) {

                try {

                    $player = $coc->getPlayer($member['tag']);

                    $heroes = collect(
                        $player['heroes'] ?? []
                    );

                    Clasher::updateOrCreate(
                        [
                            'tag' => $player['tag'],
                        ],
                        [
                            'name' => $player['name'],

                            'clan_name' => $player['clan']['name'] ?? null,
                            'clan_tag' => $player['clan']['tag'] ?? null,

                            'town_hall' => $player['townHallLevel'],

                            'war_stars' => $player['warStars'] ?? 0,
                            'exp_level' => $player['expLevel'] ?? 0,

                            'king' => $heroes
                                ->firstWhere('name', 'Barbarian King')['level'] ?? 0,

                            'queen' => $heroes
                                ->firstWhere('name', 'Archer Queen')['level'] ?? 0,

                            'warden' => $heroes
                                ->firstWhere('name', 'Grand Warden')['level'] ?? 0,

                            'champion' => $heroes
                                ->firstWhere('name', 'Royal Champion')['level'] ?? 0,
                        ]
                    );

                    $saved++;

                } catch (\Exception $e) {

                    $failed++;

                    continue;
                }
            }

            $message = "{$saved} pemain berhasil disimpan.";

            if ($failed > 0) {
                $message .= " {$failed} pemain gagal diproses.";
            }

            return redirect()
                ->route('clashers.index')
                ->with('success', $message);

        } catch (\Exception $e) {

            return back()
                ->with(
                    'error',
                    'Gagal mengambil data clan: ' . $e->getMessage()
                );
        }
    }

    public function storeMemberProgress(Request $request,ClashOfClansService $coc) 
    {
        try {

            $player = $coc->getPlayer($request->tag);

            $heroes = collect($player['heroes'] ?? []);

            Clasher::updateOrCreate(
                [
                    'tag' => $player['tag'],
                ],
                [
                    'name' => $player['name'],

                    'clan_name' => $player['clan']['name'] ?? null,
                    'clan_tag' => $player['clan']['tag'] ?? null,

                    'town_hall' => $player['townHallLevel'],

                    'war_stars' => $player['warStars'] ?? 0,
                    'exp_level' => $player['expLevel'] ?? 0,

                    'king' => $heroes
                        ->firstWhere('name', 'Barbarian King')['level'] ?? 0,

                    'queen' => $heroes
                        ->firstWhere('name', 'Archer Queen')['level'] ?? 0,

                    'warden' => $heroes
                        ->firstWhere('name', 'Grand Warden')['level'] ?? 0,

                    'champion' => $heroes
                        ->firstWhere('name', 'Royal Champion')['level'] ?? 0,
                ]
            );

            return response()->json([
                'success' => true,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);

        }
    }
}