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

            <h3 class="text-lg font-bold text-gray-800">
                Group {{ $index + 1 }}
            </h3>

            <span class="px-3 py-1 text-sm bg-blue-100 text-blue-700 rounded-full">
                {{ $members->count() }} akun
            </span>

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

    @endforeach

</div>

@endsection