@extends('layouts.app')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">
                Monitoring Clan
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Kelola clan yang akan disinkronisasi ke sistem.
            </p>
        </div>
    </div>

    

    <div class="flex justify-end gap-3">

    <x-button data-modal-target="addClanModal">
        <i class="fa-solid fa-plus mr-2"></i>
        Tambah Clan
    </x-button>

    <x-button
        variant="secondary"
        data-modal-target="searchClanModal"
    >
        <i class="fa-solid fa-magnifying-glass mr-2"></i>
        Cari Clan
    </x-button>

</div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">
                Daftar Clan
            </h2>
        </div>

        @if($clans->isEmpty())

            <div class="py-12 text-center text-slate-500">
                Belum ada clan yang ditambahkan.
            </div>

        @else

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Nama Clan
                            </th>

                            <th class="px-6 py-3 text-left font-semibold text-slate-600">
                                Tag
                            </th>

                            <th class="px-6 py-3 text-center font-semibold text-slate-600">
                                Status
                            </th>

                            <th class="px-6 py-3 text-center font-semibold text-slate-600">
                                Aksi
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach($clans as $clan)

                            <tr class="hover:bg-slate-50">

                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $clan->name }}
                                </td>

                                <td class="px-6 py-4 text-slate-600">
                                    {{ $clan->tag }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if($clan->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4 text-center">

                                    <form
                                        action="{{ route('clans.toggle', $clan) }}"
                                        method="POST"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="px-4 py-2 rounded-lg text-white text-sm
                                            {{ $clan->is_active
                                                ? 'bg-red-600 hover:bg-red-700'
                                                : 'bg-green-600 hover:bg-green-700' }}"
                                        >
                                            {{ $clan->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @endif

    </div>

</div>

    <x-modal
        id="searchClanModal"
        title="Cari Clan">

        <form
            method="POST"
            action="{{ route('clan.search') }}"
        >
            @csrf

            <input
                type="hidden"
                name="modal"
                value="searchClanModal"
            >

            <x-input
                name="tag"
                label="Tag Clan"
                placeholder="#2ABC123"
                :value="old('tag')"
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
                    loading
                    loading-text="Mencari..."
                >
                    Cari
                </x-button>

            </div>

        </form>

    </x-modal>
    <x-modal
    id="addClanModal"
    title="Tambah Clan">

    <form
        action="{{ route('clans.store') }}"
        method="POST"
    >
        @csrf

        <input
            type="hidden"
            name="modal"
            value="addClanModal"
        >

        <x-input
            name="tag"
            label="Tag Clan"
            placeholder="#2QJY9GULP"
            :value="old('tag')"
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
                loading
                loading-text="Menyimpan..."
            >
                Tambah Clan
            </x-button>

        </div>

    </form>

</x-modal>
@endsection