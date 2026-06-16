<?php

namespace App\Http\Controllers;

use App\Models\Clan;
use Illuminate\Support\Facades\Artisan;

class WarController extends Controller
{
    public function index()
    {
        $clans = Clan::with([
            'wars' => function ($query) {
                $query->latest('start_time');
            }
        ])->get();

        return view('wars.index', compact('clans'));
    }

   public function show(\App\Models\War $war)
{
    $war->load([
        'clan',
        'members' => function ($query) {
            $query->orderBy('map_position');
        }
    ]);

    return view('wars.show', compact('war'));
}
public function sync()
{
    try {

        Artisan::call('coc:sync-current-wars');

        $output = Artisan::output();

        return response()->json([
            'success' => true,
            'message' => 'Sinkronisasi selesai.',
            'output' => $output,
        ]);

    } catch (\Throwable $e) {

        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}
}