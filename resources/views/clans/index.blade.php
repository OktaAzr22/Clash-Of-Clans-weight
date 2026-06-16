@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Tombol Cari Clan --}}
    <div class="flex justify-end">

        <x-button data-modal-target="searchClanModal">
            <i class="fa-solid fa-magnifying-glass mr-2"></i>
            Cari Clan
        </x-button>

    </div>

    {{-- Modal Cari Clan --}}
    <x-modal
        id="searchClanModal"
        title="Cari Clan"
    >

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

    @isset($clan)

        {{-- Informasi Clan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <h2 class="text-2xl font-bold text-slate-800">
                        {{ $clan['name'] }}
                    </h2>

                    <p class="text-slate-500 mt-1 font-mono">
                        {{ $clan['tag'] }}
                    </p>

                </div>

                <div class="flex flex-wrap gap-3">

                    <span class="px-4 py-2 rounded-xl bg-blue-100 text-blue-700 text-sm font-medium">
                        {{ $clan['members'] }}/50 Anggota
                    </span>

                    <span class="px-4 py-2 rounded-xl bg-amber-100 text-amber-700 text-sm font-medium">
                        Level {{ $clan['clanLevel'] }}
                    </span>

                    <span class="px-4 py-2 rounded-xl bg-green-100 text-green-700 text-sm font-medium">
                        {{ number_format($clan['clanPoints']) }} Trophy
                    </span>

                </div>

            </div>

        </div>

        {{-- Daftar Anggota --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

            <div class="px-6 py-4 border-b border-slate-200">

                <h3 class="font-semibold text-slate-800">
                    Daftar Anggota Clan
                </h3>

            </div>

            <div class="overflow-auto max-h-[600px] hide-scrollbar">

                <table class="w-full text-sm">

                    <thead class="bg-slate-50 sticky top-0 z-10">

                        <tr class="text-slate-600">

                            <th class="px-6 py-4 text-left font-semibold">
                                Nama
                            </th>

                            <th class="px-6 py-4 text-left font-semibold">
                                Tag
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                Role
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                Level
                            </th>

                            <th class="px-6 py-4 text-center font-semibold">
                                Trophy
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @php
                            $roles = [
                                'leader' => 'Leader',
                                'coLeader' => 'Co-Leader',
                                'admin' => 'Elder',
                                'member' => 'Member',
                            ];
                        @endphp

                        @foreach($clan['memberList'] as $member)

                            <tr class="hover:bg-slate-50 transition">

                                <td class="px-6 py-4 font-medium text-slate-800">
                                    {{ $member['name'] }}
                                </td>

                                <td class="px-6 py-4 font-mono text-slate-600">
                                    {{ $member['tag'] }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-medium">

                                        {{ $roles[$member['role']] ?? ucfirst($member['role']) }}

                                    </span>

                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ $member['expLevel'] }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    {{ number_format($member['trophies']) }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Tombol Simpan --}}
        <div class="flex justify-end">

            <x-button
                data-modal-target="saveClanMembersModal"
            >
                <i class="fa-solid fa-download mr-2"></i>
                Simpan {{ $clan['members'] }} Pemain ke Database
            </x-button>

        </div>

        {{-- Modal Simpan --}}
<x-modal
    id="saveClanMembersModal"
    title="Simpan Anggota Clan"
>

    {{-- Konfirmasi --}}
    <div id="confirmSaveSection">

        <p class="text-slate-600">
            Anda akan menyimpan
            <span class="font-bold">
                {{ count($clan['memberList']) }} anggota clan
            </span>
            ke database.
        </p>

        <p class="text-slate-500 text-sm mt-2">
            Proses ini mungkin membutuhkan beberapa saat.
        </p>

    </div>

    {{-- Progress --}}
    <div
        id="progressSection"
        class="hidden text-center py-8"
    >

        <div class="mb-6">

            <i
                id="progressIcon"
                class="fa-solid fa-database text-5xl text-blue-600 animate-pulse"
            ></i>

        </div>

        <h3
            id="progressTitle"
            class="text-lg font-bold text-slate-800"
        >
            Menyimpan Anggota Clan
        </h3>

        <p
            id="progressDescription"
            class="text-slate-500 mt-2"
        >
            Mohon tunggu sampai proses selesai.
        </p>

        <div class="mt-6">

            <div class="w-full bg-slate-200 rounded-full h-4 overflow-hidden">

                <div
                    id="progressBar"
                    class="bg-blue-600 h-4 transition-all duration-300"
                    style="width: 0%"
                ></div>

            </div>

            <p
                id="progressText"
                class="mt-3 font-semibold text-slate-700"
            >
                0 / {{ count($clan['memberList']) }}
            </p>

        </div>

    </div>

    {{-- Tombol --}}
    <div
        id="confirmButtons"
        class="flex justify-end gap-2 mt-6"
    >

        <x-button
            type="button"
            variant="secondary"
            class="close-modal"
        >
            Batal
        </x-button>

        <x-button
            type="button"
            id="saveClanMembersBtn"
        >
            Ya, Simpan Semua
        </x-button>

    </div>

</x-modal>

    @endisset

</div>

@if(isset($clan))
<script>

const members = @json($clan['memberList']);

let savingClanMembers = false;

document
    .getElementById('saveClanMembersBtn')
    ?.addEventListener('click', async function () {

        if (savingClanMembers) {
            return;
        }

        savingClanMembers = true;

        const confirmSection =
            document.getElementById('confirmSaveSection');

        const progressSection =
            document.getElementById('progressSection');

        const confirmButtons =
            document.getElementById('confirmButtons');

        const progressBar =
            document.getElementById('progressBar');

        const progressText =
            document.getElementById('progressText');

        const progressTitle =
            document.getElementById('progressTitle');

        const progressDescription =
            document.getElementById('progressDescription');

        const progressIcon =
            document.getElementById('progressIcon');

        /*
        |--------------------------------------------------------------------------
        | Mode Progress
        |--------------------------------------------------------------------------
        */

        confirmSection.classList.add('hidden');

        confirmButtons.classList.add('hidden');

        progressSection.classList.remove('hidden');

        /*
        |--------------------------------------------------------------------------
        | Sembunyikan tombol close
        |--------------------------------------------------------------------------
        */

        document
            .querySelectorAll(
                '#saveClanMembersModal .close-modal'
            )
            .forEach(button => {
                button.classList.add('hidden');
            });

        const total = members.length;

        for (let i = 0; i < total; i++) {

            try {

                const response = await fetch(
                    "{{ route('clan.store-member-progress') }}",
                    {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({
                            tag: members[i].tag
                        })
                    }
                );

                const result = await response.json();

                if (!response.ok || !result.success) {

                    progressIcon.className =
                        'fa-solid fa-circle-xmark text-5xl text-red-600';

                    progressTitle.textContent =
                        'Proses Gagal';

                    progressDescription.textContent =
                        result.message ??
                        `Gagal menyimpan ${members[i].name}`;

                    progressBar.classList.remove('bg-blue-600');
                    progressBar.classList.add('bg-red-600');

                    savingClanMembers = false;

                    return;
                }

                const current = i + 1;

                progressBar.style.width =
                    `${(current / total) * 100}%`;

                progressText.textContent =
                    `${current} / ${total}`;

            } catch (error) {

                console.error(error);

                progressIcon.className =
                    'fa-solid fa-circle-xmark text-5xl text-red-600';

                progressTitle.textContent =
                    'Terjadi Kesalahan';

                progressDescription.textContent =
                    'Tidak dapat terhubung ke server.';

                progressBar.classList.remove('bg-blue-600');
                progressBar.classList.add('bg-red-600');

                savingClanMembers = false;

                return;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Selesai
        |--------------------------------------------------------------------------
        */

        progressBar.style.width = '100%';

        progressBar.classList.remove('bg-blue-600');
        progressBar.classList.add('bg-green-600');

        progressText.textContent =
            `Selesai (${total}/${total})`;

        progressIcon.className =
            'fa-solid fa-circle-check text-5xl text-green-600';

        progressTitle.textContent =
            'Penyimpanan Berhasil';

        progressDescription.textContent =
            'Semua anggota berhasil disimpan. Mengalihkan ke daftar clasher...';

        savingClanMembers = false;

        setTimeout(() => {

            window.location =
                "{{ route('clashers.index') }}";

        }, 2000);

    });

</script>
@endif
@endsection