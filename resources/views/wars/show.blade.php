@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="bg-white rounded-2xl shadow border p-6 mb-6">

        <h1 class="text-2xl font-bold">
            {{ $war->clan->name }}
            vs
            {{ $war->opponent_name }}
        </h1>

        <div class="mt-4 flex flex-wrap gap-6">

            <div>
    <div class="text-sm text-slate-500">
        Status
    </div>

    <div class="font-semibold">
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
    </div>

    @if($war->remaining_time)
        <div class="text-sm text-slate-500 mt-1">
            Sisa {{ $war->remaining_time }}
        </div>
    @endif
</div>

            <div>
                <div class="text-sm text-slate-500">
                    Stars
                </div>

                <div class="font-semibold text-lg">
                    {{ $war->clan_stars }}
                    ⭐
                    -
                    {{ $war->opponent_stars }}
                    ⭐
                </div>
            </div>

            <div>
                <div class="text-sm text-slate-500">
                    Destruction
                </div>

                <div class="font-semibold">
                    {{ number_format($war->clan_destruction, 2) }}%
                    -
                    {{ number_format($war->opponent_destruction, 2) }}%
                </div>
            </div>

        </div>

    </div>

    {{-- Daftar Anggota --}}
    <div class="bg-white rounded-2xl shadow border overflow-hidden">

        <div class="px-6 py-4 border-b">
            <h2 class="font-semibold text-lg">
                Anggota War
            </h2>
        </div>

        @if($war->members->isEmpty())

            <div class="p-10 text-center text-slate-500">
                Data anggota belum tersedia.
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr>
                            <th class="px-6 py-3 text-left">
                                Posisi
                            </th>

                            <th class="px-6 py-3 text-left">
                                Nama
                            </th>

                            <th class="px-6 py-3 text-center">
                                TH
                            </th>

                            <th class="px-6 py-3 text-center">
                                Serangan
                            </th>

                            <th class="px-6 py-3 text-center">
                                Status
                            </th>
                        </tr>

                    </thead>

                    <tbody class="divide-y">

                        @foreach($war->members as $member)

                            <tr>

                                <td class="px-6 py-4 font-medium">
                                    #{{ $member->map_position }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $member->name }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    TH{{ $member->town_hall }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $member->attacks_used }}/{{ $war->attacks_per_member }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if($member->attacks_used == 0)

                                        <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-medium">
                                            ❌ Belum Menyerang
                                        </span>

                                    @elseif($member->attacks_used < $war->attacks_per_member)

                                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-medium">
                                            ⚠️ Belum Selesai
                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-medium">
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