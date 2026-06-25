
<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BaseGroupController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\ClasherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ThBuildingController;
use App\Http\Controllers\WarController;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Clashers
|--------------------------------------------------------------------------
*/

Route::prefix('clashers')
    ->name('clashers.')
    ->controller(ClasherController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::post('/', 'store')
            ->name('store');

        Route::get('/overview', 'overview')
            ->name('overview');

        Route::get('/{clasher}/war-profile', 'warProfile')
            ->name('war-profile');

        Route::post('/{clasher}/war-profile', 'saveWarProfile')
            ->name('war-profile.save');
    });

/*
|--------------------------------------------------------------------------
| TH Buildings
|--------------------------------------------------------------------------
*/

Route::resource('th-buildings', ThBuildingController::class)
    ->only([
        'index',
        'create',
        'store',
        'destroy',
    ]);

/*
|--------------------------------------------------------------------------
| Buildings
|--------------------------------------------------------------------------
*/

Route::prefix('buildings')
    ->name('buildings.')
    ->controller(BuildingController::class)
    ->group(function () {

        Route::post('/', 'store')
            ->name('store');
    });

/*
|--------------------------------------------------------------------------
| Clans
|--------------------------------------------------------------------------
*/

Route::prefix('clans')
    ->name('clans.')
    ->controller(ClanController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::post('/', 'store')
            ->name('store');

        Route::post('/search', 'search')
            ->name('search');

        Route::post('/members', 'storeMembers')
            ->name('members.store');

        Route::post('/members/progress', 'storeMemberProgress')
            ->name('members.progress.store');

        Route::patch('/{clan}/toggle', 'toggle')
            ->name('toggle');
    });

/*
|--------------------------------------------------------------------------
| Wars
|--------------------------------------------------------------------------
*/

Route::prefix('wars')
    ->name('wars.')
    ->controller(WarController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/{war}', 'show')
            ->name('show');
    });

/*
|--------------------------------------------------------------------------
| Base Groups
|--------------------------------------------------------------------------
*/

Route::prefix('base-groups')
    ->name('base-groups.')
    ->controller(BaseGroupController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::post('/update-label', 'updateLabel')
            ->name('update-label');
    });