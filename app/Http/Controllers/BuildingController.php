<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::latest()->get();

        return view('buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('buildings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'min:3',
                'unique:buildings,name',
            ],
        ]);

        Building::create([
            'name' => trim($request->name),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Bangunan berhasil ditambahkan.');
    }
}