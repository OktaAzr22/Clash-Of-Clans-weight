<div class="mb-6 pb-4 border-b border-slate-200">

    <div class="flex flex-wrap items-center gap-3">

        <h2 class="text-xl font-bold text-slate-800">
            {{ $clasher->name }}
        </h2>

        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-sm font-mono">
            {{ $clasher->tag }}
        </span>

    </div>

</div>
<form
    method="POST"
    action="{{ route('clashers.war-profile.save', $clasher) }}"
    class="space-y-5"
>

    @csrf

    @if($buildings->isEmpty())

        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-8 text-center">

            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-amber-100 flex items-center justify-center">
                <i class="fa-solid fa-triangle-exclamation text-2xl text-amber-600"></i>
            </div>

            <h3 class="text-xl font-bold text-amber-800 mb-2">
                Data Bangunan Belum Tersedia
            </h3>

            <p class="text-amber-700 max-w-md mx-auto">
                Data bangunan untuk Town Hall
                <span class="font-semibold">
                    {{ $clasher->town_hall }}
                </span>
                belum tersedia. Silakan tambahkan data bangunan terlebih dahulu agar profil war dapat diisi.
            </p>

        </div>

    @else

    @foreach($buildings as $item)

        <div class="rounded-2xl border border-slate-200 overflow-hidden bg-white shadow-sm">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4 text-white">

                <div class="flex flex-wrap items-center justify-between gap-3">

                    <div>
                        <h3 class="font-semibold text-lg">
                            {{ $item->building->name }}
                        </h3>

                        <p class="text-sm text-blue-100">
                            {{ $item->quantity }} bangunan harus diisi
                        </p>
                    </div>

                    <div class="flex gap-2">

                        <span class="px-3 py-1 rounded-full bg-white/20 text-sm">
                            Max Lv {{ $item->max_level }}
                        </span>

                        <span class="px-3 py-1 rounded-full bg-amber-400 text-amber-900 text-sm font-semibold">
                            TH {{ $clasher->town_hall }}
                        </span>

                    </div>

                </div>

            </div>

            {{-- Body --}}
            <div class="p-6 bg-slate-50">

                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-4">

                    @for($i = 1; $i <= $item->quantity; $i++)

                        <div class="bg-white border-2 border-slate-200 rounded-2xl p-4 shadow-sm">

                            <div class="text-center mb-3">

                                <div class="font-semibold text-slate-700">
                                    {{ $item->building->name }} #{{ $i }}
                                </div>

                                <div class="text-xs text-slate-500 mt-1">
                                    Level Bangunan
                                </div>

                            </div>

                            <input
                                type="number"
                                min="0"
                                max="{{ $item->max_level }}"
                                required
                                name="levels[{{ $item->building_id }}][{{ $i }}]"
                                value="{{ old(
                                    'levels.' . $item->building_id . '.' . $i,
                                    $existingLevels[
                                        $item->building_id . '_' . $i
                                    ]->level ?? ''
                                ) }}"
                                class="w-full
                                      text-center
                                      text-3xl
                                      font-bold
                                      py-4
                                      rounded-xl
                                      border-2
                                      border-blue-300
                                      bg-blue-50
                                      focus:border-blue-600
                                      focus:ring-4
                                      focus:ring-blue-200"
                            >

                        </div>

                    @endfor

                </div>

            </div>

        </div>

    @endforeach

    {{-- Tombol Simpan --}}
    <div class="pt-6 mt-6 border-t border-slate-200 flex justify-end gap-3">

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
            loading-text="Memperbarui Data..."
        >
            <i class="fa-solid fa-download mr-2"></i>
            Simpan Data
        </x-button>

    </div>

@endif

    

    

</form>