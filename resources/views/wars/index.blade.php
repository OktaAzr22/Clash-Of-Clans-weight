@extends('layouts.app')

@section('content')

<div class="space-y-6">

{{-- Header --}}
<div class="flex items-center justify-between">

    <div>

        <h1 class="text-2xl font-bold text-slate-800">
            Monitoring War
        </h1>

        <p class="text-sm text-slate-500 mt-1">
            Pantau status war seluruh clan yang aktif.
        </p>

    </div>

</div>

{{-- Tabel --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
@if($clans->isEmpty())

    
<x-empty-state
    icon="fa-solid fa-shield-halved text-2xl text-slate-400"
    title="Belum Ada Clan"
    message="Data clan belum tersedia. Silakan tambahkan clan terlebih dahulu untuk memantau status war."
/>
@else
    <div class="px-6 py-4 border-b border-slate-200">

        <h2 class="text-lg font-semibold text-slate-800">
            Daftar War Clan
        </h2>

    </div>

    

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Clan
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Tag
                        </th>

                        <th class="px-6 py-3 text-center font-semibold text-slate-600">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left font-semibold text-slate-600">
                            Lawan
                        </th>

                        <th class="px-6 py-3 text-center font-semibold text-slate-600">
                            Sisa Waktu
                        </th>

                        <th class="px-6 py-3 text-center font-semibold text-slate-600">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @foreach($clans as $clan)

                        @php
                            $war = $clan->wars->first();
                        @endphp

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $clan->name }}
                            </td>

                            <td class="px-6 py-4 font-mono text-slate-500">
                                {{ $clan->tag }}
                            </td>

                            @if($war)

                                <td class="px-6 py-4 text-center">

                                    @php
                                        $statusColor = match($war->state) {
                                            'preparation' => 'bg-amber-100 text-amber-700',
                                            'inWar' => 'bg-green-100 text-green-700',
                                            'warEnded' => 'bg-slate-100 text-slate-700',
                                            default => 'bg-blue-100 text-blue-700',
                                        };
                                    @endphp

                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">

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

                                </td>

                                <td class="px-6 py-4 text-slate-700">
                                    {{ $war->opponent_name }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if($war->state === 'warEnded')

                                        <span class="text-slate-500">
                                            Selesai
                                        </span>

                                    @else

                                        <span class="font-medium text-slate-700">
                                            {{ $war->remaining_time ?? '-' }}
                                        </span>

                                    @endif

                                </td>

                                <td class="px-6 py-4 text-center">

                                    <a
                                        href="{{ route('wars.show', $war) }}"
                                        class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:bg-blue-700 transition"
                                    >
                                        Detail
                                    </a>

                                </td>

                            @else

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        No War
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-slate-400">
                                    -
                                </td>

                                <td class="px-6 py-4 text-center text-slate-400">
                                    -
                                </td>

                                <td class="px-6 py-4 text-center text-slate-400">
                                    -
                                </td>

                            @endif

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>


</div>

@endsection
