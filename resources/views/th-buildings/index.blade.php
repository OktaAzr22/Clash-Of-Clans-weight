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

            @if($thBuildings->isEmpty())

                <div class="py-12">

                    <div class="flex flex-col items-center">

                        <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">

                            <i class="fa-solid fa-building text-2xl text-slate-400"></i>

                        </div>

                        <h3 class="text-lg font-semibold text-slate-700">
                            Belum Ada Konfigurasi
                        </h3>

                        <p class="text-slate-500 mt-2 text-center max-w-md">
                            Data konfigurasi Town Hall Building belum tersedia.
                            Silakan tambahkan konfigurasi terlebih dahulu.
                        </p>

                    </div>

                </div>

            @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">

                        <tr class="text-slate-600">
                            <th class="px-6 py-4 text-left font-semibold">ID</th>
                            <th class="px-6 py-4 text-left font-semibold">Town Hall</th>
                            <th class="px-6 py-4 text-left font-semibold">Building</th>
                            <th class="px-6 py-4 text-left font-semibold">Jumlah</th>
                            <th class="px-6 py-4 text-left font-semibold">Max Level</th>
                            <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">
                        @foreach($thBuildings as $item)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="px-6 py-4">{{ $item->id }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-medium">
                                        TH {{ $item->town_hall }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium text-slate-700">{{ $item->building->name }}</td>
                                <td class="px-6 py-4">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 font-bold text-slate-800">{{ $item->max_level }}</td>
                                <td class="px-6 py-4 text-center">
                                    <button 
                                        type="button"
                                        class="btn-edit-th-building text-blue-600 hover:text-blue-800 font-medium text-sm"
                                        data-id="{{ $item->id }}"
                                        data-th="{{ $item->town_hall }}"
                                        data-building="{{ $item->building_id }}"
                                        data-quantity="{{ $item->quantity }}"
                                        data-maxlevel="{{ $item->max_level }}"
                                        data-url="{{ route('th-buildings.update', $item->id) }}"
                                        data-modal-target="editThBuildingModal">
                                        <i class="fa-solid fa-pen-to-square mr-1"></i> Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

            @endif

        </div>

    </div>

    <x-modal id="createBuildingModal" title="Tambah Building">
        <form method="POST" action="{{ route('buildings.store') }}">

            @csrf

            <input type="hidden" name="modal" value="createBuildingModal">
            <x-input name="name" label="Nama Building" required/>

            <div class="mt-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">
                    Status Priority
                </label>

                <select name="is_priority" class="w-full rounded-lg border-slate-300" required>
                    <option value="1">
                        Priority
                    </option>

                    <option value="0">
                        Non Priority
                    </option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <x-button
                    variant="secondary"
                    type="button"
                    class="close-modal"
                >
                    Batal
                </x-button>

                <x-button type="submit" loading loading-text="Menyimpan...">
                    Simpan
                </x-button>

            
            </div>

        </form>

    </x-modal>

    <x-modal id="createThBuildingModal" title="Tambah Konfigurasi TH" size="lg">

        <form method="POST" action="{{ route('th-buildings.store') }}">
            @csrf

            <input type="hidden" name="modal" value="createThBuildingModal">
            <x-input name="town_hall" label="Town Hall" type="number" min="1" max="17" required/>
            <div class="mb-4">

                <x-select name="building_id" label="Building" required >

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
            <x-input name="quantity" label="Jumlah Bangunan" type="number" min="1" required />
            <x-input name="max_level" label="Max Level" type="number" min="1" required />
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

    <x-modal id="viewBuildingModal" title="Daftar Building" size="xl">

        @if($buildings->isEmpty())

            <div class="py-10 text-center text-slate-500">
                Data building belum tersedia.
            </div>

        @else

            <div class="overflow-y-auto flex-1 space-y-2">

                @foreach($buildings as $building)

                    <div class="flex items-center gap-4 p-3 rounded-xl border border-slate-100 bg-white hover:bg-slate-50 hover:shadow-md transition-all duration-200 hover:border-blue-200 group">

                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-sm flex-shrink-0">
                            {{ $loop->iteration }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-slate-800 group-hover:text-blue-600 transition">
                                {{ $building->name }}
                            </p>
                            <p class="text-xs text-slate-400">
                                Building ID: #{{ $building->id }}
                            </p>
                        </div>

                        <div class="flex items-center gap-1">
                            <button class="p-2 rounded-lg hover:bg-blue-50 text-slate-400 hover:text-blue-600 transition" title="Detail">
                                <i class="fas fa-chevron-right text-sm"></i>
                            </button>
                        </div>

                    </div>

                @endforeach

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

    <x-modal id="editThBuildingModal" title="Edit Level & Jumlah Bangunan" size="lg">
    <form id="editThBuildingForm" method="POST" action="">
        @csrf
        @method('PUT')

        {{-- Hidden input untuk data statis --}}
        <input type="hidden" id="edit_town_hall" name="town_hall">
        <input type="hidden" id="edit_building_id" name="building_id">

        {{-- Informasi Statis --}}
        <div class="grid grid-cols-2 gap-4 mb-4 bg-slate-50 p-4 rounded-xl border border-slate-200">
            <div>
                <p class="text-xs text-slate-500 font-medium">Town Hall</p>
                <p id="display_town_hall" class="text-base font-bold text-blue-600">-</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Nama Bangunan</p>
                <p id="display_building_name" class="text-base font-bold text-slate-800">-</p>
            </div>
        </div>

        {{-- Field yang Boleh Diubah (ID otomatis mengikuti atribut name) --}}
        <x-input
            name="max_level"
            label="Max Level (Level Bangunan)"
            type="number"
            min="1"
            required
        />

        <x-input
            name="quantity"
            label="Jumlah Bangunan"
            type="number"
            min="1"
            required
        />

        <div class="flex justify-end gap-2 mt-6">
            <x-button variant="secondary" type="button" class="close-modal">
                Batal
            </x-button>

            <x-button type="submit" loading loading-text="Menyimpan...">
                Update Level
            </x-button>
        </div>
    </form>
</x-modal>
    {{-- Script JavaScript untuk Mengisi Data Edit Ke Modal --}}
  <script>
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.btn-edit-th-building');
    const form = document.getElementById('editThBuildingForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const url = this.getAttribute('data-url');
            const th = this.getAttribute('data-th');
            const buildingId = this.getAttribute('data-building');
            const quantity = this.getAttribute('data-quantity');
            const maxLevel = this.getAttribute('data-maxlevel');
            
            // Ambil nama building dari baris tabel
            const row = this.closest('tr');
            const buildingName = row ? row.cells[2].innerText.trim() : '';

            // Set Action Form
            if (form) form.action = url;

            // Set Hidden Input
            document.getElementById('edit_town_hall').value = th;
            document.getElementById('edit_building_id').value = buildingId;

            // Set Info Display
            document.getElementById('display_town_hall').innerText = 'TH ' + th;
            document.getElementById('display_building_name').innerText = buildingName;

            // Target elemen input di dalam form edit modal
            form.querySelector('input[name="max_level"]').value = maxLevel;
            form.querySelector('input[name="quantity"]').value = quantity;
        });
    });
});
</script>

@endsection