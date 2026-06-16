@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Statistik Utama --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Total Clasher --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Total Clasher
                    </p>

                    <h2 class="text-3xl font-bold text-slate-800 mt-2">
                        {{ number_format($totalClashers) }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center">
                    <i class="fa-solid fa-users text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        {{-- TH Tertinggi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        TH Tertinggi
                    </p>

                    <h2 class="text-3xl font-bold text-amber-600 mt-2">
                        TH {{ $highestTownHall ?? '-' }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center">
                    <i class="fa-solid fa-chess-rook text-2xl text-amber-600"></i>
                </div>
            </div>
        </div>

        {{-- Sudah Isi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        War Profile Terisi
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        {{ number_format($filledProfiles) }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">
                    <i class="fa-solid fa-shield-halved text-2xl text-green-600"></i>
                </div>
            </div>
        </div>

        {{-- Belum Isi --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Belum Isi Profile
                    </p>

                    <h2 class="text-3xl font-bold text-red-600 mt-2">
                        {{ number_format($emptyProfiles) }}
                    </h2>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center">
                    <i class="fa-solid fa-triangle-exclamation text-2xl text-red-600"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- Distribusi TH & Quick Action --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Distribusi TH --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <h3 class="text-lg font-semibold text-slate-800 mb-6">
                Distribusi Town Hall
            </h3>

            <div class="space-y-4">

                @foreach($townHallDistribution as $item)

                    <div>

                        <div class="flex justify-between text-sm mb-1">

                            <span class="font-medium text-slate-700">
                                TH {{ $item->town_hall }}
                            </span>

                            <span class="text-slate-500">
                                {{ $item->total }} pemain
                            </span>

                        </div>

                        <div class="w-full bg-slate-100 rounded-full h-3">

                            <div
                                class="bg-blue-600 h-3 rounded-full"
                                style="width: {{ ($item->total / max($townHallDistribution->pluck('total')->max(),1)) * 100 }}%"
                            ></div>

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

        {{-- Quick Action --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <h3 class="text-lg font-semibold text-slate-800 mb-6">
                Quick Action
            </h3>

            <div class="space-y-3">

                <a
                    href="{{ route('clashers.index') }}"
                    class="flex items-center gap-3 p-4 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition"
                >
                    <i class="fa-solid fa-plus"></i>
                    Kelola Clasher
                </a>

                <a
                    href="{{ route('clashers.overview') }}"
                    class="flex items-center gap-3 p-4 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 transition"
                >
                    <i class="fa-solid fa-ranking-star"></i>
                    Lihat Overview
                </a>

            </div>

        </div>

    </div>

    {{-- Top Profile & Perlu Update --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Top Profile --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <h3 class="text-lg font-semibold text-slate-800 mb-6">
                🏆 Top 5 War Profile
            </h3>

            <div class="space-y-4">

                @forelse($topProfiles as $clasher)

                    <div class="flex items-center justify-between">

                        <div>
                            <p class="font-semibold text-slate-800">
                                {{ $clasher->name }}
                            </p>

                            <p class="text-sm text-slate-500">
                                TH {{ $clasher->town_hall }}
                            </p>
                        </div>

                        <span class="px-3 py-2 rounded-xl bg-blue-50 text-blue-700 font-semibold">
                            {{ number_format($clasher->total_level) }}
                        </span>

                    </div>

                @empty

                    <p class="text-slate-500">
                        Belum ada data.
                    </p>

                @endforelse

            </div>

        </div>

        {{-- Perlu Update --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <h3 class="text-lg font-semibold text-slate-800 mb-6">
                ⏰ Perlu Update
            </h3>

            <div class="space-y-4">

                @forelse($needUpdate as $clasher)

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="font-semibold text-slate-800">
                                {{ $clasher->name }}
                            </p>

                            <p class="text-sm text-slate-500">
                                TH {{ $clasher->town_hall }}
                            </p>

                        </div>

                        <span class="text-sm text-slate-500">

                            @if($clasher->last_war_profile_update)

                                {{ $clasher->last_war_profile_update->diffForHumans() }}

                            @else

                                Belum pernah

                            @endif

                        </span>

                    </div>

                @empty

                    <p class="text-slate-500">
                        Tidak ada data.
                    </p>

                @endforelse

            </div>

        </div>

    </div>

</div>
<p>Clan vs Lawan
Status war (Preparation/In War/Ended)
Sisa waktu war</p>

@endsection

