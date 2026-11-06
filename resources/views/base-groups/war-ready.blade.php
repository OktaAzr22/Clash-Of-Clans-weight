@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <div class="flex justify-between items-center mb-6">

        <h1 class="text-2xl font-bold">
            Clasher Stay - Ready War
        </h1>

        <a
            href="{{ route('base-groups.index') }}"
            class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700"
        >
            Kembali
        </a>

    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-slate-100">

                <tr>
                    <th class="text-left px-4 py-3">
                        Nama
                    </th>

                    <th class="text-left px-4 py-3">
                        TH
                    </th>

                    <th class="text-left px-4 py-3">
                        Status War
                    </th>
                </tr>

            </thead>

            <tbody>

                @foreach($clashers as $clasher)

                    <tr class="border-t">

                        <td class="px-4 py-3">
                            {{ $clasher->name }}
                        </td>

                        <td class="px-4 py-3">
                            TH {{ $clasher->town_hall }}
                        </td>

                        <td class="px-4 py-3">

                            <div class="flex gap-6">

                                <label class="flex items-center gap-2">

                                    <input
                                        type="radio"
                                        name="war_status_{{ $clasher->id }}"
                                        value="1"
                                        data-id="{{ $clasher->id }}"
                                        {{ $clasher->is_ready_war ? 'checked' : '' }}
                                    >

                                    <span>
                                        Siap War
                                    </span>

                                </label>

                                <label class="flex items-center gap-2">

                                    <input
                                        type="radio"
                                        name="war_status_{{ $clasher->id }}"
                                        value="0"
                                        data-id="{{ $clasher->id }}"
                                        {{ !$clasher->is_ready_war ? 'checked' : '' }}
                                    >

                                    <span>
                                        Tidak Siap
                                    </span>

                                </label>

                            </div>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

<script>

document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('input[type="radio"]')
        .forEach(radio => {

            radio.addEventListener('change', function () {

                fetch(
                    "{{ url('base-groups/war-ready') }}/" + this.dataset.id,
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            status: this.value
                        })
                    }
                )
                .then(response => response.json())
                .then(data => {

                    console.log(data);

                })
                .catch(error => {

                    console.error(error);

                });

            });

        });

});

</script>

@endsection