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
{{-- Distribusi TH --}}
<div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

    {{-- Header --}}
    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h3 class="text-lg font-bold text-slate-800">
                Distribusi Town Hall
            </h3>

            <p class="text-sm text-slate-500 mt-1">
                Komposisi akun berdasarkan level Town Hall
            </p>
        </div>

        <div class="w-12 h-12 rounded-2xl bg-blue-100 flex items-center justify-center">
            <i class="fa-solid fa-chess-rook text-blue-600 text-xl"></i>
        </div>
    </div>

    {{-- Content --}}
    <div class="p-6">

        @php
            $maxTotal = max($townHallDistribution->max('total'), 1);
        @endphp

        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

            @foreach($townHallDistribution as $item)

                @php
                    $percentage = round(($item->total / $maxTotal) * 100);
                @endphp

                <div
                    class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-gradient-to-br from-white to-slate-50 p-5 hover:shadow-lg hover:-translate-y-1 transition duration-300"
                >

                    {{-- Background Glow --}}
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-blue-100 opacity-40 group-hover:scale-125 transition">
                    </div>

                    {{-- TH --}}
                    <div class="relative flex items-center justify-between">

                        <div>
                            <p class="text-xs uppercase tracking-wider text-slate-400">
                                Town Hall
                            </p>

                            <h4 class="text-2xl font-bold text-slate-800 mt-1">
                                TH {{ $item->town_hall }}
                            </h4>
                        </div>

                        <div
                            class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center"
                        >
                            <i class="fa-solid fa-fort-awesome text-lg"></i>
                        </div>

                    </div>

                    {{-- Total --}}
                    <div class="relative mt-5">

                        <p class="text-3xl font-bold text-slate-800">
                            {{ $item->total }}
                        </p>

                        <p class="text-sm text-slate-500">
                            Akun
                        </p>

                    </div>

                    {{-- Progress --}}
                    <div class="relative mt-4">

                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">

                            <div
                                class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

{{-- Distribusi TH --}}
<div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">

        <div>
            <h3 class="text-lg font-semibold text-slate-800">
                Distribusi Town Hall
            </h3>

            <p class="text-sm text-slate-500">
                Sebaran akun berdasarkan level Town Hall
            </p>
        </div>

        <span class="text-sm text-slate-400">
            {{ $totalClashers }} Akun
        </span>

    </div>

    <div class="p-6">

        {{-- Bar Distribusi --}}
        <div class="flex h-10 rounded-xl overflow-hidden bg-slate-100">

            @php
                $total = max($townHallDistribution->sum('total'), 1);

                $colors = [
                    'bg-red-500',
                    'bg-orange-500',
                    'bg-amber-500',
                    'bg-yellow-500',
                    'bg-lime-500',
                    'bg-green-500',
                    'bg-emerald-500',
                    'bg-cyan-500',
                    'bg-sky-500',
                    'bg-blue-500',
                    'bg-indigo-500',
                    'bg-violet-500',
                    'bg-purple-500',
                ];
            @endphp

            @foreach($townHallDistribution as $index => $item)

                <div
                    class="{{ $colors[$index % count($colors)] }}
                           flex items-center justify-center
                           text-white text-xs font-bold
                           hover:brightness-110 transition"
                    style="width: {{ ($item->total / $total) * 100 }}%"
                    title="TH {{ $item->town_hall }} ({{ $item->total }} akun)"
                >
                    TH {{ $item->town_hall }}
                </div>

            @endforeach

        </div>

        {{-- Legend --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-6">

            @foreach($townHallDistribution as $index => $item)

                <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3">

                    <div class="flex items-center gap-2">

                        <span class="w-3 h-3 rounded-full {{ $colors[$index % count($colors)] }}"></span>

                        <span class="font-medium text-slate-700">
                            TH {{ $item->town_hall }}
                        </span>

                    </div>

                    <span class="font-semibold text-slate-800">
                        {{ $item->total }}
                    </span>

                </div>

            @endforeach

        </div>

    </div>

</div>

{{-- Distribusi TH --}}
<div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">

        <div>
            <h3 class="text-lg font-semibold text-slate-800">
                Komposisi Town Hall
            </h3>

            <p class="text-sm text-slate-500">
                Sebaran kekuatan akun dalam clan
            </p>
        </div>

        <div class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 text-sm font-semibold">
            {{ $totalClashers }} Akun
        </div>

    </div>

    <div class="p-6">

        @php
            $maxTotal = max($townHallDistribution->max('total'), 1);
        @endphp

        <div class="space-y-5">

            @foreach($townHallDistribution->sortByDesc('town_hall') as $item)

                @php
                    $percentage = ($item->total / $maxTotal) * 100;
                @endphp

                <div>

                    <div class="flex items-center justify-between mb-2">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center">
                                <i class="fa-solid fa-fort-awesome text-amber-600"></i>
                            </div>

                            <div>

                                <h4 class="font-semibold text-slate-800">
                                    TH {{ $item->town_hall }}
                                </h4>

                                <p class="text-xs text-slate-500">
                                    Town Hall Level {{ $item->town_hall }}
                                </p>

                            </div>

                        </div>

                        <div class="text-right">

                            <span class="text-lg font-bold text-slate-800">
                                {{ $item->total }}
                            </span>

                            <span class="text-sm text-slate-500">
                                akun
                            </span>

                        </div>

                    </div>

                    <div class="relative">

                        <div class="h-3 bg-slate-100 rounded-full overflow-hidden">

                            <div
                                class="h-full rounded-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-600"
                                style="width: {{ $percentage }}%"
                            ></div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

        {{-- Ringkasan --}}
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="bg-slate-50 rounded-xl p-4">

                <p class="text-xs text-slate-500 uppercase tracking-wide">
                    TH Dominan
                </p>

                <p class="text-xl font-bold text-blue-600 mt-1">
                    TH {{ $townHallDistribution->sortByDesc('total')->first()?->town_hall }}
                </p>

            </div>

            <div class="bg-slate-50 rounded-xl p-4">

                <p class="text-xs text-slate-500 uppercase tracking-wide">
                    Total TH Aktif
                </p>

                <p class="text-xl font-bold text-emerald-600 mt-1">
                    {{ $townHallDistribution->count() }}
                </p>

            </div>

            <div class="bg-slate-50 rounded-xl p-4">

                <p class="text-xs text-slate-500 uppercase tracking-wide">
                    TH Tertinggi
                </p>

                <p class="text-xl font-bold text-amber-600 mt-1">
                    TH {{ $highestTownHall }}
                </p>

            </div>

        </div>

    </div>

</div>
@endsection

