





@extends('layouts.app')
@section('content')

<div class="space-y-6">

    {{-- Header Actions --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Daftar TH Building
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Kelola konfigurasi Town Hall dan building Clash of Clans.
            </p>
        </div>

        <div class="flex flex-wrap gap-2">

            <x-button data-modal-target="createThBuildingModal">
                <i class="fa-solid fa-plus mr-2"></i>
                Tambah Konfigurasi
            </x-button>

            <x-button
                variant="secondary"
                data-modal-target="createBuildingModal"
            >
                <i class="fa-solid fa-building mr-2"></i>
                Tambah Building
            </x-button>

            <x-button
                variant="info"
                data-modal-target="viewBuildingModal"
            >
                <i class="fa-solid fa-eye mr-2"></i>
                Lihat Building
            </x-button>

        </div>

    </div>

    {{-- Table Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200">

            <h3 class="font-semibold text-slate-800">
                Data Konfigurasi TH Building
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50">

                    <tr class="text-slate-600">

                        <th class="px-6 py-4 text-left font-semibold">
                            ID
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Town Hall
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Building
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Jumlah
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Max Level
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($thBuildings as $item)

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4">
                                {{ $item->id }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                    TH {{ $item->town_hall }}
                                </span>

                            </td>

                            <td class="px-6 py-4 font-medium text-slate-700">
                                {{ $item->building->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->quantity }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $item->max_level }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="5"
                                class="px-6 py-12 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <i class="fa-regular fa-folder-open text-4xl text-slate-300 mb-3"></i>

                                    <p class="text-slate-500">
                                        Belum ada konfigurasi TH Building.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
<x-modal id="createBuildingModal" title="Tambah Building">

    <form
        method="POST"
        action="{{ route('buildings.store') }}">

        @csrf

        <input
            type="hidden"
            name="modal"
            value="createBuildingModal"
        >

        <x-input
            name="name"
            label="Nama Building"
            required
        />

        <div class="flex justify-end gap-2">

            <x-button
                type="button"
                variant="secondary"
                class="close-modal"
            >
                Batal
            </x-button>

            <x-button
                type="submit"
                loading-text="Menyimpan..."
            >
                Simpan
            </x-button>

        </div>

    </form>

</x-modal>

<x-modal id="createThBuildingModal" title="Tambah Konfigurasi TH" size="lg">

    <form
        method="POST"
        action="{{ route('th-buildings.store') }}">
        @csrf

        <input
            type="hidden"
            name="modal"
            value="createThBuildingModal"
        >

        <x-input
            name="town_hall"
            label="Town Hall"
            type="number"
            min="1"
            max="17"
            required
        />

        <div class="mb-4">

            <x-select
                name="building_id"
                label="Building"
                required
            >

                <option value="">
                    -- Pilih Building --
                </option>

                @foreach($buildings as $building)

                    <option
                        value="{{ $building->id }}"
                        @selected(old('building_id') == $building->id)
                    >
                        {{ $building->name }}
                    </option>

                @endforeach

            </x-select>

        </div>

        <x-input
            name="quantity"
            label="Jumlah Bangunan"
            type="number"
            min="1"
            required
        />

        <x-input
            name="max_level"
            label="Max Level"
            type="number"
            min="1"
            required
        />

        <div class="flex justify-end gap-2 mt-6">

            <x-button
                variant="secondary"
                type="button"
                class="close-modal"
            >
                Batal
            </x-button>

            <x-button
                type="submit"
                loading
                loading-text="Menyimpan..."
            >
                Simpan
            </x-button>

        </div>

    </form>

</x-modal>

<x-modal
    id="viewBuildingModal"
    title="Daftar Building"
    size="3xl">

    @if($buildings->isEmpty())

        <div class="py-10 text-center text-slate-500">
            Data building belum tersedia.
        </div>

    @else

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="sticky top-0 bg-slate-50 z-10">

                    <tr class="border-b bg-slate-50">

                        <th class="px-4 py-3 text-left">
                            ID
                        </th>

                        <th class="px-4 py-3 text-left">
                            Nama Building
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($buildings as $building)

                        <tr class="border-b hover:bg-slate-50">

                            <td class="px-4 py-3">
                                {{ $building->id }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $building->name }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

    <div class="flex justify-end mt-6">

        <x-button
            variant="secondary"
            type="button"
            class="close-modal"
        >
            Tutup
        </x-button>

    </div>

</x-modal>
@endsection