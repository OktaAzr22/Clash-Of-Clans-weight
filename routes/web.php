<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BaseGroupController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\ClanController;
use App\Http\Controllers\ClasherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ThBuildingController;
use App\Http\Controllers\WarController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

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

Route::resource('th-buildings', ThBuildingController::class)
    ->only([
        'index',
        'create',
        'store',
        'destroy',
    ]);

Route::prefix('buildings')
    ->name('buildings.')
    ->controller(BuildingController::class)
    ->group(function () {

        Route::post('/', 'store')
            ->name('store');
    });

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

Route::prefix('wars')
    ->name('wars.')
    ->controller(WarController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::get('/{war}', 'show')
            ->name('show');
    });

Route::prefix('base-groups')
    ->name('base-groups.')
    ->controller(BaseGroupController::class)
    ->group(function () {

        Route::get('/', 'index')
            ->name('index');

        Route::post('/update-label', 'updateLabel')
            ->name('update-label');

            Route::get('/war-ready', 'warReady')
            ->name('war-ready');

        

            Route::post('/war-ready/{clasher}', 'updateWarReady')
    ->name('war-ready.update');
    });