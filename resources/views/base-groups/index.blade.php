@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- FILTER --}}
    <form class="bg-white p-4 rounded-lg shadow flex items-center gap-4">

        <label class="text-sm font-medium text-gray-600">
            Filter TH:
        </label>

        <select
            name="th"
            onchange="this.form.submit()"
            class="border rounded-lg p-2 text-sm focus:ring focus:ring-blue-200"
        >
            <option value="">Pilih TH</option>

            @foreach($ths as $th)
                <option value="{{ $th }}" @selected(request('th') == $th)>
                    TH {{ $th }}
                </option>
            @endforeach
        </select>

    </form>


    {{-- EMPTY STATE --}}
    @if($groups->isEmpty())
        <div class="bg-white p-6 rounded-lg shadow text-center text-gray-500">
            Pilih TH terlebih dahulu untuk menampilkan data
        </div>
    @endif


    {{-- SUMMARY --}}
    @if(request('th'))
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm">Total Group</div>
            <div class="text-3xl font-bold">{{ $totalGroups }}</div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm">Total Akun</div>
            <div class="text-3xl font-bold">{{ $totalAccounts }}</div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <div class="text-gray-500 text-sm">Rata-rata / Grup</div>
            <div class="text-3xl font-bold">{{ $average }}</div>
        </div>

    </div>
    @endif


    {{-- GROUP LIST --}}
    @foreach($groups as $index => $members)

    <div class="bg-white rounded-xl shadow p-6 space-y-5">

        {{-- HEADER GROUP --}}
        <div class="flex justify-between items-center border-b pb-3">

    <div class="flex items-center gap-3">

        <h3 class="text-lg font-bold text-gray-800">
            Group {{ $index + 1 }}
        </h3>

        @php
            $groupLabel = $members->first()->label ?? 'belum ada';
        @endphp

        @if($groupLabel === 'stay')
            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                Stay
            </span>

        @elseif($groupLabel === 'perlu up')
            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                Perlu Up
            </span>

        @else
            <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-700">
                Belum Ada
            </span>
        @endif

    </div>

    <div class="flex items-center gap-2">

        <span class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-full">
            {{ $members->count() }} akun
        </span>

        <button
            type="button"
            data-modal-target="label-modal-{{ $index }}"
            class="px-3 py-1.5 rounded-lg bg-slate-800 text-white text-sm hover:bg-slate-700"
        >
            Update Label
        </button>

    </div>

</div>


        {{-- BUILDING INFO --}}
        @php
            $sample = $members->first();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">

            @foreach($sample->buildings->groupBy('building_name') as $building => $items)

            <div class="flex justify-between bg-gray-50 px-3 py-2 rounded">

                <span class="font-medium text-gray-700">
                    {{ $building }}
                </span>

                <span class="text-gray-600">

                    @foreach($items as $item)
                        {{ $item->level }}
                    @endforeach

                </span>

            </div>

            @endforeach

        </div>


        {{-- MEMBERS --}}
        <div class="border-t pt-4">

            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">

                @foreach($members as $member)

                    <div class="bg-slate-100 hover:bg-slate-200 transition rounded-lg px-3 py-2 text-sm">
                        {{ $member->name }}
                    </div>

                @endforeach

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

</div>


@endsection