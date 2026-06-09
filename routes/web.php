<?php

use App\Http\Controllers\ClasherController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\ThBuildingController;
use App\Http\Controllers\WarController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Clashers
|--------------------------------------------------------------------------
*/

Route::controller(ClasherController::class)->group(function () {

    Route::get('/clashers', 'index')->name('clashers.index');
    Route::get('/clashers/create', 'create')->name('clashers.create');
    Route::post('/clashers/store', 'store')->name('clashers.store');
    Route::get('/clashers/{clasher}/war-profile', 'warProfile')->name('clashers.war-profile');
    Route::post('/clashers/{clasher}/war-profile', 'saveWarProfile')->name('clashers.war-profile.save');

});

Route::resource('buildings', BuildingController::class);

Route::resource('th-buildings',ThBuildingController::class);

Route::get(
    '/clans/search',
    [ClanController::class, 'search']
)->name('clans.search');

Route::post(
    '/clans/result',
    [ClanController::class, 'result']
)->name('clans.result');

Route::post(
    '/clans/analyze',
    [ClanController::class, 'analyze']
)->name('clans.analyze');

Route::post(
    '/clans/generate',
    [ClanController::class, 'generate']
)->name('clans.generate');


Route::post(
    '/wars/store',
    [WarController::class, 'store']
)->name('wars.store');