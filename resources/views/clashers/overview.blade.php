@extends('layouts.app')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                Overview Clasher
            </h2>

            <p class="text-sm text-slate-500 mt-1">
                Lihat perkembangan level bangunan berdasarkan Town Hall.
            </p>
        </div>

        <a href="{{ route('clashers.index') }}"
           class="inline-flex items-center px-4 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Kembali ke Daftar Clasher
        </a>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">

        <div class="p-6">

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">

                {{-- Select --}}
                <div class="w-full lg:w-80">

                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Pilih Town Hall
                    </label>

                    <div class="relative">

                        <i class="fa-solid fa-house-chimney absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>

                        <select
                            id="thSelect"
                            name="th"
                            class="w-full pl-11 pr-4 py-3 rounded-xl border border-slate-300 bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition"
                        >
                            <option value="all">
                                Semua Town Hall
                            </option>

                            @foreach($townHalls as $th)
                                <option value="{{ $th }}" @selected($selectedTh == $th)>
                                    TH {{ $th }}
                                </option>
                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- Info Filter Aktif --}}
                <div class="flex items-center gap-3 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3">

                    

                   <div class="flex items-center gap-2 text-sm">
    <span class="text-slate-500">Menampilkan data:</span>

    <span
        id="selectedThText"
        class="font-semibold text-blue-600"
    >
        {{ $selectedTh == 'all' ? 'Semua Town Hall' : 'TH '.$selectedTh }}
    </span>
</div>

                </div>

            </div>

        </div>

    </div>

    <hr>

    {{-- AJAX CONTENT --}}
    <div id="overviewWrapper" class="transition-opacity duration-300">

        <div id="overviewContainer">
            @include('clashers.partials.overview-list')
        </div>

    </div>

    {{-- SKELETON --}}
    <div id="skeletonContainer" class="hidden space-y-6">

        @for ($i = 0; $i < 2; $i++)
            <div class="bg-white rounded-2xl border border-slate-200 p-6 animate-pulse">

                <div class="flex justify-between mb-6">

                    <div class="space-y-2">
                        <div class="h-4 w-40 bg-slate-200 rounded"></div>
                        <div class="h-3 w-24 bg-slate-200 rounded"></div>
                    </div>

                    <div class="flex gap-2">
                        <div class="h-6 w-16 bg-slate-200 rounded"></div>
                        <div class="h-6 w-24 bg-slate-200 rounded"></div>
                    </div>

                </div>

                <div class="space-y-2">

                    @for ($r = 0; $r < 4; $r++)
                        <div class="h-10 bg-slate-100 rounded"></div>
                    @endfor

                </div>

            </div>
        @endfor

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const select = document.getElementById('thSelect');
    const container = document.getElementById('overviewContainer');
    const skeleton = document.getElementById('skeletonContainer');
    const wrapper = document.getElementById('overviewWrapper');
    const selectedThText = document.getElementById('selectedThText');

    select.addEventListener('change', async function () {

        const th = this.value;

        // Update badge filter aktif
        selectedThText.textContent =
            th === 'all'
                ? 'Semua Town Hall'
                : `TH ${th}`;

        // Fade content
        wrapper.style.opacity = "0.3";

        // Show skeleton
        skeleton.classList.remove('hidden');
        container.classList.add('hidden');

        try {

            const res = await fetch(`?th=${th}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const html = await res.text();

            setTimeout(() => {

                container.innerHTML = html;

                skeleton.classList.add('hidden');
                container.classList.remove('hidden');

                wrapper.style.opacity = "1";

            }, 200);

        } catch (err) {

            console.error(err);

            skeleton.classList.add('hidden');
            container.classList.remove('hidden');
            wrapper.style.opacity = "1";
        }

    });

});
</script>

@endsection