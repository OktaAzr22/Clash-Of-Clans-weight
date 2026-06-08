<?php

use App\Http\Controllers\ClasherController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ThBuildingController;
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


