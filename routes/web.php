<?php

use App\Http\Controllers\BaseGroupController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClasherController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\ThBuildingController;
use App\Http\Controllers\WarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/',[DashboardController::class, 'index'])->name('dashboard');

Route::controller(ClasherController::class)->group(function () {

    Route::get('/clashers', 'index')
        ->name('clashers.index');

    Route::post('/clashers/store', 'store')
        ->name('clashers.store');

    Route::get('/clashers/{clasher}/war-profile', 'warProfile')
        ->name('clashers.war-profile');

    Route::post('/clashers/{clasher}/war-profile', 'saveWarProfile')
        ->name('clashers.war-profile.save');

    Route::get('/clashers/overview', 'overview')
        ->name('clashers.overview');

});

Route::controller(ThBuildingController::class)->group(function () {

    Route::get('/th-buildings', 'index')
        ->name('th-buildings.index');

    Route::get('/th-buildings/create', 'create')
        ->name('th-buildings.create');

    Route::post('/th-buildings', 'store')
        ->name('th-buildings.store');

});

Route::post('/buildings',[BuildingController::class, 'store'])->name('buildings.store');



// Route::get('/clan', [ClanController::class, 'index'])
//     ->name('clan.index');

Route::post('/clan/search', [ClanController::class, 'search'])
    ->name('clan.search');

    Route::post(
    '/clan/store-members',
    [ClanController::class, 'storeMembers']
)->name('clan.store-members');

Route::post(
    '/clan/store-member-progress',
    [ClanController::class, 'storeMemberProgress']
)->name('clan.store-member-progress');

Route::prefix('clans')
    ->name('clans.')
    ->group(function () {

        Route::get('/', [ClanController::class, 'index'])
            ->name('index');

        Route::post('/', [ClanController::class, 'store'])
            ->name('store');

        Route::patch(
            '/{clan}/toggle',
            [ClanController::class, 'toggle']
        )->name('toggle');
    });



    



Route::prefix('wars')
    ->name('wars.')
    ->group(function () {

        Route::get('/', [WarController::class, 'index'])
            ->name('index');

        Route::get('/{war}', [WarController::class, 'show'])
            ->name('show');

        
    });



    Route::get('/clashers/compare', [ClasherController::class, 'compareBots'])
    ->name('clashers.compare');

    Route::delete(
    '/th-buildings/{thBuilding}',
    [ThBuildingController::class, 'destroy']
)->name('th-buildings.destroy');

Route::get('/clashers/overview-raw', [ClasherController::class, 'overviewRaw']);

Route::get('/base-groups', [BaseGroupController::class, 'index'])
    ->name('base-groups.index');

    Route::post(
    '/base-groups/update-label',
    [BaseGroupController::class, 'updateLabel']
)->name('base-groups.update-label');

Route::get(
    '/clashers/label/{label}',
    [ClasherController::class, 'label']
)->name('clashers.label');
//  saya ingin ada table relasi baru ynag ngambil data clasher lalu isinya bisa tau akun mana yang ada progres gitu semisal yang tadinya akun ini th 12 mau ada progres ke th 14 gitu 