<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClasherController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\ThBuildingController;
use App\Http\Controllers\WarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/a', function () {
    return view('test');
});
/*
|--------------------------------------------------------------------------
| Clashers
|--------------------------------------------------------------------------
*/

Route::controller(ClasherController::class)->group(function () {

    Route::get('/clashers', 'index')
        ->name('clashers.index');

    Route::get('/clashers/create', 'create')
        ->name('clashers.create');

    Route::post('/clashers/store', 'store')
        ->name('clashers.store');

    Route::get('/clashers/{clasher}/war-profile', 'warProfile')
        ->name('clashers.war-profile');

    Route::post('/clashers/{clasher}/war-profile', 'saveWarProfile')
        ->name('clashers.war-profile.save');

    Route::get('/clashers/overview', 'overview')
        ->name('clashers.overview');

});


/*
|--------------------------------------------------------------------------
| Buildings
|--------------------------------------------------------------------------
*/

Route::controller(BuildingController::class)->group(function () {

    Route::get('/buildings', 'index')
        ->name('buildings.index');

    Route::post('/buildings', 'store')
        ->name('buildings.store');

});


/*
|--------------------------------------------------------------------------
| TH Buildings
|--------------------------------------------------------------------------
*/

Route::controller(ThBuildingController::class)->group(function () {

    Route::get('/th-buildings', 'index')
        ->name('th-buildings.index');

    Route::get('/th-buildings/create', 'create')
        ->name('th-buildings.create');

    Route::post('/th-buildings', 'store')
        ->name('th-buildings.store');

    

});


/*
|--------------------------------------------------------------------------
| Clans
|--------------------------------------------------------------------------
*/

Route::get('/clans/search', [ClanController::class, 'search'])
    ->name('clans.search');

Route::post('/clans/result', [ClanController::class, 'result'])
    ->name('clans.result');

Route::post('/clans/analyze', [ClanController::class, 'analyze'])
    ->name('clans.analyze');

Route::post('/clans/generate', [ClanController::class, 'generate'])
    ->name('clans.generate');


/*
|--------------------------------------------------------------------------
| Wars
|--------------------------------------------------------------------------
*/

Route::post('/wars/store', [WarController::class, 'store'])
    ->name('wars.store');