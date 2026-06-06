<?php

use App\Http\Controllers\ClasherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clashers/create', [ClasherController::class, 'create']);
Route::post('/clashers/store', [ClasherController::class, 'store']);


use Illuminate\Support\Facades\Http;

Route::get('/test-coc', function () {

    $tag = 'g2rlopo9u'; // ganti dengan tag akun Anda TANPA #

    $response = Http::withHeaders([
        'Authorization' => 'Bearer '.config('services.coc.token'),
    ])->get(
        "https://api.clashofclans.com/v1/players/%23{$tag}"
    );

    return $response->json();
});

use App\Services\ClashOfClansService;

Route::get('/player-test', function () {

    $coc = new ClashOfClansService();

    return $coc->getPlayer('#g2rlopo9u');
});