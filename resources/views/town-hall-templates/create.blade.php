
@extends('layouts.app')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="mb-6">

        <div class="flex items-center gap-3 mb-2">

            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">

                <i class="fas fa-plus"></i>

            </div>

            <div>

                <h2 class="text-2xl font-bold text-slate-800">

                    Tambah Template Town Hall

                </h2>

                <p class="text-sm text-slate-500 mt-1">

                    Buat template baru untuk menentukan standar building setiap Town Hall.

                </p>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">

        <div class="px-6 py-5 border-b border-slate-200 bg-gradient-to-r from-slate-50 to-white">

            <h3 class="text-base font-semibold text-slate-800">

                Informasi Template

            </h3>

        </div>

        <form
            action="{{ route('town-hall-templates.store') }}"
            method="POST"
            class="p-6 space-y-6"
        >

            @csrf

            <div>

                <label class="block text-sm font-medium text-slate-700 mb-2">

                    Town Hall

                </label>

                <select
                    name="town_hall"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                >

                    <option value="">

                        -- Pilih Town Hall --

                    </option>

                    @foreach($townHalls as $th)

                        <option
                            value="{{ $th }}"
                            @selected(old('town_hall') == $th)
                        >

                            TH {{ $th }}

                        </option>

                    @endforeach

                </select>

                @error('town_hall')

                    <p class="text-sm text-red-500 mt-2">

                        {{ $message }}

                    </p>

                @enderror

            </div>

            <div>

                <label class="block text-sm font-medium text-slate-700 mb-2">

                    Nama Template

                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Hybrid / Farming / CWL"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    required
                >

                @error('name')

                    <p class="text-sm text-red-500 mt-2">

                        {{ $message }}

                    </p>

                @enderror

                <p class="text-xs text-slate-500 mt-2">

                    Gunakan nama yang mudah dikenali untuk tipe progression atau strategi base.

                </p>

            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-200">

                <a
                    href="{{ route('town-hall-templates.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 hover:bg-slate-50 transition text-sm font-medium"
                >

                    <i class="fas fa-arrow-left"></i>

                    Kembali

                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition text-sm font-medium shadow-sm"
                >

                    <i class="fas fa-arrow-right"></i>

                    Lanjut Atur Building

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

