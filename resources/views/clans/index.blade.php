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

    <div class="space-y-4">

        <div class="rounded-xl bg-amber-50 border border-amber-200 p-4">

            <p class="font-semibold text-amber-800">
                Konfirmasi Simpan Anggota Clan
            </p>

            <p class="text-sm text-amber-700 mt-2">
                Sistem akan mengambil detail seluruh anggota clan dari API Clash of Clans dan menyimpannya ke database.
            </p>

        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">

            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200">

                <p class="text-xs text-slate-500">
                    Clan
                </p>

                <p class="font-semibold text-slate-800 mt-1">
                    {{ $clan['name'] }}
                </p>

            </div>

            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200">

                <p class="text-xs text-slate-500">
                    Tag Clan
                </p>

                <p class="font-mono font-semibold text-slate-800 mt-1">
                    {{ $clan['tag'] }}
                </p>

            </div>

            <div class="rounded-xl bg-slate-50 p-4 border border-slate-200">

                <p class="text-xs text-slate-500">
                    Total Anggota
                </p>

                <p class="font-semibold text-slate-800 mt-1">
                    {{ $clan['members'] }} Pemain
                </p>

            </div>

        </div>

        <div class="rounded-xl bg-blue-50 border border-blue-200 p-4">

            <ul class="text-sm text-blue-800 space-y-2">

                <li>• Pemain baru akan ditambahkan.</li>

                <li>• Pemain yang sudah ada akan diperbarui.</li>

                <li>• Proses berlangsung bertahap dengan progress.</li>

            </ul>

        </div>

        {{-- Progress --}}
        <div
            id="saveProgress"
            class="hidden"
        >

            <p class="text-sm text-slate-600 mb-2">
                Menyimpan anggota clan...
            </p>

            <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">

                <div
                    id="progressBar"
                    class="bg-blue-600 h-3 rounded-full transition-all duration-300"
                    style="width: 0%"
                ></div>

            </div>

            <p
                id="progressText"
                class="text-center text-sm font-semibold text-slate-700 mt-2"
            >
                0 / {{ count($clan['memberList']) }}
            </p>

        </div>

    </div>

    <div class="flex justify-end gap-2 mt-6">

        <x-button
            type="button"
            variant="secondary"
            class="close-modal"
            id="cancelSaveBtn"
        >
            Batal
        </x-button>

        <x-button
            type="button"
            id="saveClanMembersBtn"
        >
            <i class="fa-solid fa-download mr-2"></i>
            Ya, Simpan Semua
        </x-button>

    </div>

</x-modal>

    @endisset

</div>
@if(isset($clan))
<script>
const members = @json($clan['memberList']);

document
    .getElementById('saveClanMembersBtn')
    ?.addEventListener('click', async function () {

        const progressBox = document.getElementById('saveProgress');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');

        const saveButton = this;
        const cancelButton = document.getElementById('cancelSaveBtn');

        progressBox.classList.remove('hidden');

        saveButton.disabled = true;
        cancelButton.disabled = true;

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

                    alert(
                        `Gagal menyimpan ${members[i].name}\n` +
                        (result.message ?? 'Unknown error')
                    );

                    console.log(result);

                    return;
                }

                const current = i + 1;

                progressBar.style.width =
                    `${(current / total) * 100}%`;

                progressText.textContent =
                    `${current} / ${total}`;

            } catch (error) {

                console.error(error);

                alert(
                    'Terjadi kesalahan saat menyimpan data.'
                );

                return;
            }
        }

        progressText.textContent =
            `Selesai (${total}/${total})`;

        alert('Semua pemain berhasil disimpan.');

        window.location =
            "{{ route('clashers.index') }}";
    });
</script>
@endif
@endsection