<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Http\Requests\StoreBuildingRequest;

class BuildingController extends Controller
{
    public function store(StoreBuildingRequest $request)
    {
        Building::create($request->validated());

        return back()->with(
            'success',
            'Bangunan berhasil ditambahkan.'
        );
    }
}