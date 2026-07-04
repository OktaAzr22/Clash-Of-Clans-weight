
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

           <x-empty-state
                title="Belum Ada Data"
                message="Pilih Town Hall terlebih dahulu untuk menampilkan group base."
            />
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

                <div
                    class="sectionHeader flex items-center justify-between px-6 py-4 border-b border-slate-200 cursor-pointer hover:bg-slate-50 transition"
                    data-target="sectionContent{{ $index }}">

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

                    

                    <div
                        class="bg-slate-100 text-slate-600 w-8 h-8 rounded-lg flex items-center justify-center"
                    >
                        <i class="fas fa-chevron-up text-xs toggleIcon"></i>
                    </div>

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

    <div class="flex items-start justify-between bg-slate-50 rounded-xl px-4 py-3 border border-slate-200 gap-3">

        <div class="flex-1">

            <p class="text-sm font-medium">
                {{ $member->name }}
            </p>

            @if($member->is_ready_war)

                <p class="text-xs font-semibold text-green-600 mt-1">
                    Ready
                </p>

            @endif


            @if(
                $member->label === 'perlu up'
                &&
                !empty($member->upgrade_notes)
            )

                <div class="mt-2 space-y-1">

                    @foreach(
                        collect($member->upgrade_notes)->take(3)
                        as $upgrade
                    )

                        <div class="text-[11px] text-yellow-700 bg-yellow-50 border border-yellow-200 rounded-lg px-2 py-1">

                            {{ $upgrade['building_name'] }}

                            Lv {{ $upgrade['current_level'] }}
                            → {{ $upgrade['expected_level'] }}

                        </div>

                    @endforeach


                    @if(count($member->upgrade_notes) > 3)

                        <div class="text-[11px] text-slate-500">

                            +{{ count($member->upgrade_notes) - 3 }}
                            upgrade lainnya

                        </div>

                    @endif

                </div>

            @endif

        </div>


        <div class="flex flex-col items-end gap-2">

            @if($member->label === 'stay')

                <span class="text-xs font-medium text-green-600 bg-green-50 px-3 py-1 rounded-full border border-green-200">
                    Stay
                </span>

            @elseif($member->label === 'perlu up')

                <span class="text-xs font-medium text-yellow-700 bg-yellow-50 px-3 py-1 rounded-full border border-yellow-200">
                    Perlu Up
                </span>

                <span class="text-[11px] text-slate-500">

                    {{ count($member->upgrade_notes ?? []) }}
                    upgrade

                </span>

            @endif

        </div>

    </div>

@endforeach
</div>


                    </div>

                </div>

            </div>

            

        @endforeach

<script>

document.querySelectorAll('.sectionHeader')
.forEach(header => {

    header.addEventListener('click', function(e) {

        // Jangan collapse jika klik tombol update label
        if (e.target.closest('.openModal')) {
            return;
        }

        const targetId = this.dataset.target;
        const content = document.getElementById(targetId);

        content.classList.toggle('hidden');

        const icon = this.querySelector('.toggleIcon');

        icon.classList.toggle('fa-chevron-up');
        icon.classList.toggle('fa-chevron-down');

    });

});
</script>

@endsection