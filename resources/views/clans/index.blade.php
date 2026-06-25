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
            data-modal-target="searchClanModal">
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

                                    <form
                                        action="{{ route('clans.toggle', $clan) }}"
                                        method="POST"
                                        class="inline-flex">
                                        @csrf
                                        @method('PATCH')

                                        <label class="relative inline-flex items-center cursor-pointer group">

                                            <input
                                                type="checkbox"
                                                class="sr-only peer"
                                                onchange="this.form.submit()"
                                                {{ $clan->is_active ? 'checked' : '' }}
                                            >

                                            <div
                                                class="relative w-11 h-6 bg-slate-300 rounded-full
                                                    peer-checked:bg-emerald-500
                                                    transition-all duration-300
                                                    after:content-['']
                                                    after:absolute
                                                    after:top-0.5
                                                    after:left-0.5
                                                    after:w-5
                                                    after:h-5
                                                    after:bg-white
                                                    after:rounded-full
                                                    after:shadow
                                                    after:transition-all
                                                    peer-checked:after:translate-x-5">
                                            </div>

                                            <div
                                                class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2
                                                    px-2 py-1 text-xs text-white bg-slate-800 rounded
                                                    opacity-0 group-hover:opacity-100
                                                    transition pointer-events-none whitespace-nowrap z-50">
                                                {{ $clan->is_active ? 'Nonaktifkan Clan' : 'Aktifkan Clan' }}
                                            </div>

                                        </label>

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
            action="{{ route('clans.search') }}">
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
            method="POST">
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