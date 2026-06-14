



@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Overview Clasher
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Lihat perkembangan level bangunan berdasarkan Town Hall.
            </p>
        </div>

        <a
            href="{{ route('clashers.index') }}"
            class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition"
        >
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Kembali ke Daftar Clasher
        </a>

    </div>
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

    <form
        method="GET"
        action="{{ route('clashers.overview') }}"
        class="flex flex-col md:flex-row gap-4 md:items-end"
    >

        <div class="w-full md:w-64">

            <label class="block text-sm font-medium text-slate-700 mb-2">
                Pilih Town Hall
            </label>

            <select
                name="th"
                class="w-full rounded-xl border-slate-300 focus:border-blue-500 focus:ring-blue-500"
            >

                <option value="all">
                    Semua Town Hall
                </option>

                @foreach($townHalls as $th)

                    <option
                        value="{{ $th }}"
                        @selected($selectedTh == $th)
                    >
                        TH {{ $th }}
                    </option>

                @endforeach

            </select>

        </div>

        <x-button type="submit">
            <i class="fa-solid fa-filter mr-2"></i>
            Tampilkan
        </x-button>

    </form>

</div>









<hr>

@if($clashers->isEmpty())

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 py-16">

        <div class="flex flex-col items-center">

            <i class="fa-regular fa-folder-open text-5xl text-slate-300 mb-4"></i>

            <p class="text-slate-500">
                Tidak ada data clasher.
            </p>

        </div>

    </div>

@else

    @foreach($clashers as $clasher)

    @php
        $groupedBuildings = $clasher->clasherBuildings
            ->groupBy(fn ($item) => $item->building->name);

        $maxRows = $groupedBuildings
            ->map(fn ($items) => $items->count())
            ->max();
    @endphp

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        {{-- Header --}}
        <div class="p-6 border-b border-slate-200">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                <div>
                    <h3 class="text-xl font-bold text-slate-800">
                        {{ $clasher->name }}
                    </h3>

                    <p class="text-sm text-slate-500 mt-1">
                        {{ $clasher->tag }}
                    </p>

                    <p class="text-sm text-slate-500">
                        {{ $clasher->clan_name ?? 'Tanpa Clan' }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">

                    <span class="px-3 py-2 rounded-xl bg-amber-100 text-amber-700 text-sm font-medium">
                        TH {{ $clasher->town_hall }}
                    </span>

                    <span class="px-3 py-2 rounded-xl bg-blue-100 text-blue-700 text-sm font-medium">
                        Total Level:
                        {{ number_format($clasher->total_level) }}
                    </span>

                    <span class="px-3 py-2 rounded-xl bg-slate-100 text-slate-700 text-sm">
                        @if($clasher->last_war_profile_update)
                            Update:
                            {{ $clasher->last_war_profile_update->format('M d, Y') }}
                        @else
                            Belum diupdate
                        @endif
                    </span>

                </div>

            </div>

        </div>

        {{-- Body --}}
        <div class="p-6">

            @if($clasher->clasherBuildings->isEmpty())

                <div class="text-center py-10">

                    <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-3"></i>

                    <p class="text-slate-500">
                        Belum ada data bangunan.
                    </p>

                </div>

            @else

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead>

                            <tr class="bg-slate-100 text-slate-700">

                                <th class="px-4 py-3 text-left font-semibold sticky left-0 bg-slate-100">
                                    Slot
                                </th>

                                @foreach($groupedBuildings as $buildingName => $items)

                                    <th class="px-4 py-3 text-center font-semibold whitespace-nowrap">
                                        {{ $buildingName }}
                                    </th>

                                @endforeach

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @for($row = 0; $row < $maxRows; $row++)

                                <tr class="hover:bg-slate-50">

                                    <td class="px-4 py-3 font-medium text-slate-600 sticky left-0 bg-white">
                                        #{{ $row + 1 }}
                                    </td>

                                    @foreach($groupedBuildings as $items)

                                        @php
                                            $level = $items->values()[$row]->level ?? null;
                                        @endphp

                                        <td class="px-4 py-3 text-center">

                                            @if($level)

                                                <span class="inline-flex items-center justify-center min-w-[40px] px-3 py-1 rounded-lg bg-blue-50 text-blue-700 font-semibold">
                                                    {{ $level }}
                                                </span>

                                            @else

                                                <span class="text-slate-300">
                                                    —
                                                </span>

                                            @endif

                                        </td>

                                    @endforeach

                                </tr>

                            @endfor

                        </tbody>

                    </table>

                </div>

            @endif

        </div>

    </div>

@endforeach

@endif

@endsection