@extends('layouts.app')

@section('content')
<x-page-header />

<h2>Daftar TH Building</h2>

<br>
<div class="flex gap-2">

    <x-button
        data-modal-target="createThBuildingModal">
        Tambah Konfigurasi
    </x-button>

    <x-button
        variant="secondary"
        data-modal-target="createBuildingModal">
        Tambah Building
    </x-button>

    <x-button
        variant="info"
        data-modal-target="viewBuildingModal">
        Lihat Building
    </x-button>

</div>
<table border="1" cellpadding="5">

    <tr>
        <th>ID</th>
        <th>TH</th>
        <th>Building</th>
        <th>Jumlah</th>
        <th>Max Level</th>
    </tr>

    @forelse($thBuildings as $item)

        <tr>

            <td>
                {{ $item->id }}
            </td>

            <td>
                TH {{ $item->town_hall }}
            </td>

            <td>
                {{ $item->building->name }}
            </td>

            <td>
                {{ $item->quantity }}
            </td>

            <td>
                {{ $item->max_level }}
            </td>

        </tr>

    @empty

        <tr>

            <td colspan="5">
                Belum ada konfigurasi TH Building.
            </td>

        </tr>

    @endforelse

</table>

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
    size="3xl"
>

    <div class="overflow-x-auto ">

        <table class="w-full text-sm">

             <thead
                class="sticky top-0 bg-slate-50 z-10"
            >

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

                @forelse($buildings as $building)

                    <tr
                        class="border-b hover:bg-slate-50"
                    >

                        <td class="px-4 py-3">
                            {{ $building->id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $building->name }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="2"
                            class="px-4 py-6 text-center text-slate-500"
                        >
                            Data building belum tersedia.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

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