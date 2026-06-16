<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use App\Services\ClashOfClansService;
use Exception;
use Illuminate\Http\Request;

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
    public function store(
        Request $request,
        ClashOfClansService $coc
    ) {
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
}