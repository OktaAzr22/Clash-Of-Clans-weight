
@extends('layouts.app')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
          <h2 class="text-2xl font-bold text-slate-800">Daftar Clasher</h2>
          <p class="text-sm text-slate-500 mt-1">Kelola data pemain Clash of Clans dan profil war mereka.</p>
        </div>
        <div class="flex gap-2">
            
            <a
                href="{{ route('base-groups.war-ready') }}"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white transition">
                <i class="fa-solid fa-shield-halved"></i>
                Kelola Bangunan
            </a>
        </div>
    </div>

    <form class="bg-white rounded-2xl shadow-md p-6 border border-slate-100 text-center md:text-left mt-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
          <div>
            <h4 class="font-bold text-slate-800">Filter Town Hall</h4>
            <p class="text-slate-500 text-sm mt-1">Pilih TH untuk melihat group base</p>
          </div>
          <select
                name="th"
                onchange="this.form.submit()"
                class="border border-slate-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-200 focus:outline-none">
                <option value="">
                    Pilih TH
                </option>

                @foreach($ths as $th)

                    <option
                        value="{{ $th }}"
                        @selected(request('th') == $th)
                    >
                        TH {{ $th }}
                    </option>

                @endforeach

            </select>
        </div>
    </form>

    <div class="space-y-6 mt-6">

        @if($groups->isEmpty())

            <div class="bg-white border border-dashed border-slate-300 rounded-2xl p-12 text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-3xl mb-5">
                    <i class="fa-solid fa-layer-group"></i>
                </div>

                <h3 class="text-lg font-semibold text-slate-700">
                    Belum Ada Data
                </h3>

                <p class="text-slate-500 mt-2">
                    Pilih Town Hall terlebih dahulu untuk menampilkan group base.
                </p>

            </div>

        @endif

        @if(request('th'))

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-sm text-slate-500">
                                Total Group
                            </div>

                            <div class="text-3xl font-bold text-slate-800 mt-2">
                                {{ $totalGroups }}
                            </div>

                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-sm text-slate-500">
                                Total Akun
                            </div>

                            <div class="text-3xl font-bold text-slate-800 mt-2">
                                {{ $totalAccounts }}
                            </div>

                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-users"></i>
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-sm text-slate-500">
                                Rata-rata / Grup
                            </div>

                            <div class="text-3xl font-bold text-slate-800 mt-2">
                                {{ $average }}
                            </div>

                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-chart-simple"></i>
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <div class="text-sm text-slate-500">
                                Total Stay
                            </div>

                            <div class="text-3xl font-bold text-slate-800 mt-2">

                                {{
                                    $groups->flatten()
                                        ->where('label', 'stay')
                                        ->count()
                                }}

                            </div>

                        </div>

                        <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>

                    </div>

                </div>

            </div>

        @endif

        @foreach($groups as $index => $members)

            @php
                $groupLabel = $members->first()->label ?? 'belum ada';

                $sample = $members->first();
            @endphp


            <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

                <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200 border-slate-200">

                    <div class="flex items-center gap-3">

                        <span class="text-sm font-semibold text-slate-700">
                            <i class="fas fa-tag mr-2 text-primary"></i>
                            Grup: {{ $index + 1 }}
                        </span>

                        @if($groupLabel === 'stay')

                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                Stay
                            </span>

                        @elseif($groupLabel === 'perlu up')

                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
                                Perlu Up
                            </span>

                        @else

                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-200 text-slate-700">
                                Belum Ada
                            </span>

                        @endif

                    </div>

                    <div class="flex items-center gap-2">

                        <button
                            type="button"
                            data-modal-target="label-modal-{{ $index }}"
                            class="bg-primary/10 text-primary text-sm font-medium px-4 py-1.5 rounded-lg hover:bg-primary/20 transition flex items-center gap-2">

                            <i class="fas fa-sync-alt"></i>

                            Update Label

                        </button>


                        <button
                            type="button"
                            class="toggleSection bg-slate-100 text-slate-600 hover:bg-slate-200 transition w-8 h-8 rounded-lg flex items-center justify-center"
                            data-target="sectionContent{{ $index }}">

                            <i class="fas fa-chevron-up text-xs toggleIcon"></i>

                        </button>

                    </div>

                </div>

                <div
                    id="sectionContent{{ $index }}"
                    class="sectionContent hidden grid grid-cols-1 md:grid-cols-3 overflow-hidden">

                    <div class="p-5 md:border-r border-slate-200 bg-white">

                        <h5 class="font-semibold text-slate-700 flex items-center gap-2 mb-4">

                            <i class="fas fa-building text-primary"></i>

                            Data Bangunan

                        </h5>


                        <ul class="space-y-4 text-sm text-slate-600">


                            <li class="flex justify-between items-center border-b border-slate-100 pb-3">

                                <span>Balai Kota</span>

                                <span class="bg-slate-100 px-3 py-1 rounded-full text-xs">

                                    Level {{ $sample->town_hall }}

                                </span>

                            </li>

                            @foreach($sample->buildings->groupBy(fn($b)=>$b->building->name) as $building => $items)

                                @php

                                    $levels = $items
                                        ->groupBy('level')
                                        ->sortKeysDesc();

                                @endphp


                                <li class="flex justify-between items-start gap-4 border-b border-slate-100 pb-3">

                                    <div>

                                        {{ $building }}

                                    </div>


                                    <div class="flex flex-wrap gap-2">

                                        @foreach($levels as $level => $group)

                                            <span class="bg-blue-50 border border-blue-200 text-blue-700 px-3 py-1 rounded-full text-xs">

                                                Lv {{ $level }}

                                                *{{ $group->count() }}

                                            </span>

                                        @endforeach


                                    </div>

                                </li>

                            @endforeach


                        </ul>

                    </div>

                    <div class="p-5 md:col-span-2 bg-white">

                        <h5 class="font-semibold text-slate-700 text-center flex items-center justify-center gap-2 mb-4">

                            <i class="fas fa-user-friends text-primary"></i>

                            Member Aktif ({{ $members->count() }})

                        </h5>


                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-80 overflow-y-auto pr-2">

                            @foreach($members as $member)

                                <div class="flex items-center justify-between bg-slate-50 rounded-xl px-4 py-3 border border-slate-200">

                                    <div>

                                        <p class="text-sm font-medium">
                                            {{ $member->name }}
                                        </p>

                                        @if($member->is_ready_war)

                                            <p class="text-xs font-semibold text-green-600 mt-1">
                                                Ready
                                            </p>

                                        @endif

                                    </div>


                                    @if($member->label === 'stay')

                                        <span class="text-xs font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full border border-green-200">
                                            Stay
                                        </span>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

            <x-modal
                id="label-modal-{{ $index }}"
                title="Update Label Group"
                size="md">

                <form
                    method="POST"
                    action="{{ route('base-groups.update-label') }}"
                    class="space-y-4">
                    @csrf

                    @foreach($members as $member)
                        <input
                            type="hidden"
                            name="ids[]"
                            value="{{ $member->id }}"
                        >
                    @endforeach

                    <div class="space-y-2">

                        <button
                            type="submit"
                            name="label"
                            value="stay"
                            class="w-full py-3 rounded-xl bg-green-500 text-white font-medium hover:bg-green-600 transition"
                        >
                            Stay
                        </button>

                        <button
                            type="submit"
                            name="label"
                            value="perlu up"
                            class="w-full py-3 rounded-xl bg-yellow-500 text-white font-medium hover:bg-yellow-600 transition"
                        >
                            Perlu Up
                        </button>

                        <button
                            type="submit"
                            name="label"
                            value="belum ada"
                            class="w-full py-3 rounded-xl bg-slate-500 text-white font-medium hover:bg-slate-600 transition"
                        >
                            Belum Ada
                        </button>

                    </div>
                </form>

            </x-modal>

        @endforeach

<script>

document.querySelectorAll('.toggleSection').forEach(btn => {

    btn.addEventListener('click', function(){

        const content = document.getElementById(
            this.dataset.target
        );

        const icon = this.querySelector('.toggleIcon');


        content.classList.toggle('hidden');

        icon.classList.toggle('fa-chevron-up');
        icon.classList.toggle('fa-chevron-down');

    });

});

</script>

@endsection