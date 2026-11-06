@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Cari Clan berdasarkan Tag</h1>

    {{-- Form Pencarian Tag --}}
    <form action="{{ route('clashers.fetch-clan') }}" method="POST" class="mb-6 max-w-md">
        @csrf
        <div class="flex gap-2">
            <input 
                type="text" 
                name="tag" 
                value="{{ old('tag', $clan['tag'] ?? request('tag')) }}" 
                placeholder="#2ABC123" 
                class="border rounded px-4 py-2 w-full @error('tag') border-red-500 @enderror"
            />
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded font-semibold hover:bg-blue-700">
                Cari
            </button>
        </div>
        @error('tag')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </form>

    {{-- Alert Flash Session / Notifikasi Error --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 max-w-3xl">
            {{ session('error') }}
        </div>
    @endif

    {{-- Hasil Pencarian Clan --}}
    @isset($clan)
        <div class="bg-white rounded-lg shadow p-6 max-w-3xl mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    @if(isset($clan['badgeUrls']['medium']))
                        <img src="{{ $clan['badgeUrls']['medium'] }}" alt="{{ $clan['name'] }}" class="w-16 h-16">
                    @endif
                    <div>
                        <h2 class="text-xl font-bold">{{ $clan['name'] }} <span class="text-gray-500 text-sm">({{ $clan['tag'] }})</span></h2>
                        <p class="text-sm text-gray-600">{{ $clan['description'] ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                {{-- Tombol Cek Anggota --}}
                <form action="{{ route('clashers.check-members') }}" method="POST">
                    @csrf
                    <input type="hidden" name="clan_tag" value="{{ $clan['tag'] }}">
                    <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded font-semibold text-sm">
                        🔍 Cek Anggota
                    </button>
                </form>
            </div>

            {{-- Info Hasil Pemeriksaan Session / Variable --}}
            @isset($info)
    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
        <h4 class="font-bold text-blue-900 mb-2">📊 Hasil Pemeriksaan Anggota:</h4>
        <ul class="text-sm text-blue-800 space-y-1 mb-4">
            <li>• Total Anggota Clan: <strong>{{ $info['total_members'] }}</strong></li>
            <li>• Sudah Terdaftar: <strong>{{ $info['registered_count'] }}</strong> (Akan dilewati)</li>
            <li>• Belum Terdaftar: <strong>{{ $info['unregistered_count'] }}</strong></li>
        </ul>

        @if($info['unregistered_count'] > 0)
            {{-- Form hanya mengirimkan tag anggota yang belum terdaftar --}}
            <form action="{{ route('clashers.store-members') }}" method="POST">
                @csrf
                @foreach($info['unregistered_tags'] as $tag)
                    <input type="hidden" name="tags[]" value="{{ $tag }}">
                @endforeach
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold text-sm">
                    💾 Simpan {{ $info['unregistered_count'] }} Clasher Baru Saja
                </button>
            </form>
        @else
            <span class="text-sm text-green-700 font-semibold">✓ Semua anggota clan sudah terdaftar di sistem!</span>
        @endif
    </div>
@endisset

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 text-center bg-gray-50 p-4 rounded">
                <div>
                    <p class="text-xs text-gray-500">Level Clan</p>
                    <p class="text-lg font-bold">{{ $clan['clanLevel'] }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Anggota</p>
                    <p class="text-lg font-bold">{{ $clan['members'] }}/50</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Total Poin</p>
                    <p class="text-lg font-bold">{{ number_format($clan['clanPoints']) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Kemenangan War</p>
                    <p class="text-lg font-bold">{{ $clan['warWins'] ?? 0 }}</p>
                </div>
            </div>

            <h3 class="font-bold text-lg mb-3">Daftar Anggota</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-100">
                            <th class="p-2">#</th>
                            <th class="p-2">Nama</th>
                            <th class="p-2">Role</th>
                            <th class="p-2">TH</th>
                            <th class="p-2">Trophy</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clan['memberList'] as $index => $member)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2">{{ $index + 1 }}</td>
                                <td class="p-2 font-medium">{{ $member['name'] }} <span class="text-xs text-gray-400">({{ $member['tag'] }})</span></td>
                                <td class="p-2 capitalize">{{ $member['role'] }}</td>
                                <td class="p-2">TH {{ $member['townHallLevel'] }}</td>
                                <td class="p-2">{{ $member['trophies'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
</div>
@endsection