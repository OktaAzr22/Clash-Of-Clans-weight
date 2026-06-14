@extends('layouts.app')

@section('content')

<div class="space-y-6">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Daftar Clasher
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Kelola data pemain Clash of Clans dan profil war mereka.
            </p>
        </div>

        <div class="flex gap-2">

            <x-button data-modal-target="createClasherModal">
                <i class="fa-solid fa-plus mr-2"></i>
                Tambah Clasher
            </x-button>

            <a
                href="{{ route('clashers.overview') }}"
                class="inline-flex items-center px-4 py-2 rounded-xl bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition"
            >
                <i class="fa-solid fa-building mr-2"></i>
                Lihat Data TH & Building
            </a>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="px-6 py-4 border-b border-slate-200">

            <h3 class="font-semibold text-slate-800">
                Data Clasher
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-slate-50">

                    <tr class="text-slate-600">

                        <th class="px-6 py-4 text-left font-semibold">
                            Nama
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Tag
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Clan
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            TH
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            War Stars
                        </th>

                        <th class="px-6 py-4 text-left font-semibold">
                            Level
                        </th>

                        <th class="px-6 py-4 text-center font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($clashers as $clasher)

                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-medium text-slate-800">
                                {{ $clasher->name }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="font-mono text-slate-600">
                                    {{ $clasher->tag }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $clasher->clan_name }}
                            </td>

                            <td class="px-6 py-4">

                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-medium">
                                    TH {{ $clasher->town_hall }}
                                </span>

                            </td>

                            <td class="px-6 py-4">
                                {{ number_format($clasher->war_stars) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $clasher->exp_level }}
                            </td>

                            <td class="px-6 py-4 text-center">

                                <x-button
                                    class="open-war-profile"
                                    data-id="{{ $clasher->id }}"
                                    data-modal-target="warProfileModal"
                                >
                                    <i class="fa-solid fa-hammer mr-2"></i>
                                    Kelola Bangunan
                                </x-button>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="px-6 py-12 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <i class="fa-regular fa-user text-4xl text-slate-300 mb-3"></i>

                                    <p class="text-slate-500">
                                        Belum ada data clasher.
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
<x-modal
    id="createClasherModal"
    title="Tambah Clasher">

    <form
        method="POST"
        action="{{ route('clashers.store') }}"
    >

        @csrf

        <input
            type="hidden"
            name="modal"
            value="createClasherModal"
        >

        <x-input
            name="tag"
            label="Tag Akun"
            placeholder="#ABC123XYZ"
            :value="old('tag')"
            required
        />

        <p class="text-sm text-slate-500 mb-6">
            Masukkan tag pemain Clash of Clans untuk mengambil data dari API.
        </p>

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
                loading-text="Mengambil Data..."
            >
                <i class="fa-solid fa-download mr-2"></i>
                Ambil & Simpan
            </x-button>

        </div>

    </form>

</x-modal>
<x-modal
    id="warProfileModal"
    title="Kelola Bangunan"
    size="3xl"
>
    <div id="warProfileContent">
        

        <div class="py-10 text-center text-slate-500">
            Memuat data...
        </div>

    </div>
</x-modal>
@endsection

<script>
document.addEventListener('DOMContentLoaded', () => {

    const content = document.getElementById('warProfileContent');

    document.querySelectorAll('.open-war-profile')
        .forEach(button => {

            button.addEventListener('click', async () => {

                const id = button.dataset.id;

                content.innerHTML = `
                    <div class="py-10 text-center text-slate-500">
                        Memuat data...
                    </div>
                `;

                try {

                    const response = await fetch(
                        `/clashers/${id}/war-profile`,
                        {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }
                    );

                    content.innerHTML = await response.text();

                } catch (e) {

                    content.innerHTML = `
                        <div class="py-10 text-center text-red-500">
                            Gagal memuat data.
                        </div>
                    `;
                }
            });

        });

});
</script>