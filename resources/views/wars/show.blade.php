
    @extends('layouts.app')

    @section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div>

            <h1 class="text-2xl font-bold text-slate-800">
                Detail War
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Monitoring progres serangan anggota selama war berlangsung.
            </p>

        </div>

        {{-- Informasi War --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        {{ $war->clan->name }}
                    </h2>

                    <p class="text-slate-500 mt-1">
                        {{ $war->opponent_name }}
                    </p>

                </div>

                <div>

                    @php
                        $statusColor = match($war->state) {
                            'preparation' => 'bg-amber-100 text-amber-700',
                            'inWar' => 'bg-green-100 text-green-700',
                            'warEnded' => 'bg-slate-100 text-slate-700',
                            default => 'bg-blue-100 text-blue-700'
                        };
                    @endphp

                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $statusColor }}">

                        @switch($war->state)
                            @case('preparation')
                                Preparation Day
                                @break

                            @case('inWar')
                                Battle Day
                                @break

                            @case('warEnded')
                                War Ended
                                @break

                            @default
                                {{ $war->state }}
                        @endswitch

                    </span>

                </div>

            </div>

            

        </div>

        {{-- Daftar Anggota --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-200">

                <h2 class="text-lg font-semibold text-slate-800">
                    Anggota War
                </h2>

            </div>

            @if($war->members->isEmpty())

                <div class="py-12 text-center text-slate-500">
                    Data anggota belum tersedia.
                </div>

            @else

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                    Posisi
                                </th>

                                <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                    Nama
                                </th>

                                <th class="px-6 py-3 text-center font-semibold text-slate-600">
                                    TH
                                </th>

                                <th class="px-6 py-3 text-center font-semibold text-slate-600">
                                    Serangan
                                </th>

                                <th class="px-6 py-3 text-center font-semibold text-slate-600">
                                    Progress
                                </th>

                                <th class="px-6 py-3 text-center font-semibold text-slate-600">
                                    Status
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach($war->members as $member)

                                @php
                                    $percentage = $war->attacks_per_member > 0
                                        ? ($member->attacks_used / $war->attacks_per_member) * 100
                                        : 0;
                                @endphp

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-6 py-4 font-medium text-slate-800">
                                        #{{ $member->map_position }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="font-medium text-slate-800">
                                            {{ $member->name }}
                                        </div>

                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        TH{{ $member->town_hall }}
                                    </td>

                                    <td class="px-6 py-4 text-center font-medium">
                                        {{ $member->attacks_used }}/{{ $war->attacks_per_member }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="w-full bg-slate-200 rounded-full h-2">

                                            <div
                                                class="bg-blue-600 h-2 rounded-full transition-all"
                                                style="width: {{ min($percentage,100) }}%"
                                            ></div>

                                        </div>

                                        <div class="text-xs text-slate-500 mt-1 text-center">
                                            {{ number_format($percentage, 0) }}%
                                        </div>

                                    </td>

                                    <td class="px-6 py-4 text-center">

                                        @if($member->attacks_used == 0)

                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                                ❌ Belum Menyerang
                                            </span>

                                        @elseif($member->attacks_used < $war->attacks_per_member)

                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                                ⚠️ Belum Selesai
                                            </span>

                                        @else

                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                ✅ Selesai
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

    @endsection
