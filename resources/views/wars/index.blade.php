@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">

    <h1 class="text-2xl font-bold">
        Monitoring War
    </h1>

    <button
    id="syncButton"
    type="button"
    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
>
    🔄 Sinkronkan
</button>

</div>
<div class="max-w-7xl mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold mb-6">
        Monitoring War
    </h1>

    <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

        @foreach($clans as $clan)

            @php
                $war = $clan->wars->first();
            @endphp

            <div class="bg-white rounded-2xl shadow border p-6">

                <h2 class="font-bold text-lg">
                    {{ $clan->name }}
                </h2>

                @if($war)

                    <p class="text-slate-500 mt-2">
                        {{ $war->state }}
                    </p>

                    <p class="mt-2">
                        Lawan:
                        {{ $war->opponent_name }}
                    </p>

                    <div class="mt-4 text-xl font-bold">
                        {{ $war->clan_stars }}
                        ⭐
                        -
                        {{ $war->opponent_stars }}
                        ⭐
                    </div>

                    <div class="mt-2 text-slate-600">
                        {{ number_format($war->clan_destruction, 2) }}%
                        -
                        {{ number_format($war->opponent_destruction, 2) }}%
                    </div>

                    <a
                        href="{{ route('wars.show', $war) }}"
                        class="inline-block mt-4 px-4 py-2 rounded-lg bg-blue-600 text-white"
                    >
                        Lihat Detail
                    </a>

                @else

                    <div class="mt-4 text-slate-500">
                        No Active War
                    </div>

                @endif

            </div>

        @endforeach

    </div>

</div>
<script>
document.getElementById('syncButton').addEventListener('click', function () {

    const button = this;

    button.disabled = true;
    button.innerHTML = '⏳ Menyinkronkan...';

    fetch('{{ route("wars.sync") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
    })
    .then(async response => {
        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.message || 'Sinkronisasi gagal.');
        }

        return data;
    })
    .then(data => {

        button.innerHTML = '✅ Berhasil';

        // Kalau controller mengembalikan output command
        if (data.output) {
            alert(data.output);
        }

        setTimeout(() => {
            location.reload();
        }, 1000);

    })
    .catch(error => {

        console.error(error);

        alert(error.message || 'Terjadi kesalahan saat sinkronisasi.');

        button.disabled = false;
        button.innerHTML = '🔄 Sinkronkan';
    });
});
</script>
@endsection