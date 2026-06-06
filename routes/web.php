<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


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