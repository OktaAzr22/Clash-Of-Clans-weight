@extends('layouts.app')

@section('content')

<x-page-header />

 
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">
            Daftar Building
        </h1>

        
        <x-button
            data-modal-target="createBuildingModal"
        >
            Tambah Building
        </x-button>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Nama Building</th>
                </tr>
            </thead>

            <tbody>
                @forelse($buildings as $building)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-3">
                            {{ $building->id }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $building->name }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-4 py-6 text-center text-gray-500">
                            Data building belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<x-modal id="createBuildingModal" title="Tambah Building" size="lg">

    <form method="POST" action="{{ route('buildings.store') }}">
        @csrf

        <input type="hidden" name="modal" value="createBuildingModal">

        <div>
            <x-input name="name"
                     label="Nama Building"
                     placeholder="Masukkan nama building"
                     required
            />
        </div>

        <div class="flex justify-end gap-2 mt-6">

           <x-button
                variant="secondary"
                type="button"
                class="close-modal"
            >
                Batal
            </x-button>

            <x-button type="submit" loading loading-text="menyimpan...">
    Simpan
</x-button>

        </div>

    </form>

</x-modal>
@endsection