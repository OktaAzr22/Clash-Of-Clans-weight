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

        <div data-modal-target="labelModal" data-label="stay" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 ">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Stay
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        {{ number_format($stayCount) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center">

                    <i class="fa-solid fa-circle-check text-2xl text-green-600"></i>

                </div>

            </div>

        </div>

        <div data-modal-target="labelModal" data-label="perlu up" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Perlu Up
                    </p>

                    <h2 class="text-3xl font-bold text-amber-600 mt-2">
                        {{ number_format($needUpCount) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center">

                    <i class="fa-solid fa-arrow-trend-up text-2xl text-amber-600"></i>

                </div>

            </div>

        </div>

        <div data-modal-target="labelModal" data-label="belum ada" class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-slate-500">
                        Belum Ada
                    </p>

                    <h2 class="text-3xl font-bold text-slate-600 mt-2">
                        {{ number_format($noLabelCount) }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center">

                    <i class="fa-solid fa-question text-2xl text-slate-600"></i>

                </div>

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

            

        </div>

    </div>
</div>


<x-modal id="labelModal" title="Daftar Akun" size="3xl">

    <div class="flex justify-between items-center mb-4">

        <p id="labelDesc" class="text-sm text-slate-500"></p>

        <span id="labelCount"
              class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-medium">
            0 akun
        </span>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full text-sm">

            <thead class="bg-slate-50">

                <tr>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Tag</th>
                    <th class="px-4 py-3 text-left">TH</th>
                </tr>

            </thead>

            <tbody id="labelAccounts"></tbody>

        </table>

    </div>

</x-modal>

<script>
    document.addEventListener('DOMContentLoaded', function () {

        const labels = @json($labels);

        document.querySelectorAll('[data-modal-target="labelModal"]').forEach(card => {

            card.addEventListener('click', () => {

                const label = card.dataset.label;

                const data = labels[label] ?? [];

                // set title text
                document.querySelector('#labelModal h3').innerText =
                    'Daftar Akun - ' + label.toUpperCase();

                // set count
                document.getElementById('labelCount').innerText =
                    data.length + ' akun';

                // set description
                document.getElementById('labelDesc').innerText =
                    'Total akun dengan label: ' + label;

                // render table
                const tbody = document.getElementById('labelAccounts');

                const wrapper = document.querySelector('#labelModal table').parentElement;

                if (!data || data.length === 0) {

                    // sembunyikan tabel + header
                    wrapper.innerHTML = `
                        <div class="text-center py-10 text-slate-500">
                            Tidak ada data untuk label ini
                        </div>
                    `;

                } else {

                    // kembalikan struktur tabel kalau ada data
                    wrapper.innerHTML = `
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-3 text-left">Nama</th>
                                    <th class="px-4 py-3 text-left">Tag</th>
                                    <th class="px-4 py-3 text-left">TH</th>
                                </tr>
                            </thead>
                            <tbody id="labelAccounts"></tbody>
                        </table>
                    `;

                    const newTbody = document.getElementById('labelAccounts');

                    newTbody.innerHTML = data.map(item => `
                        <tr class="border-b">
                            <td class="px-4 py-3">${item.name}</td>
                            <td class="px-4 py-3 font-mono">${item.tag}</td>
                            <td class="px-4 py-3">TH ${item.town_hall}</td>
                        </tr>
                    `).join('');
                }

                // open modal (punya kamu sudah ada)
                openModal('labelModal');
            });

        });

    });
</script>

@endsection