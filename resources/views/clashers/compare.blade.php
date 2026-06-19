@extends('layouts.app')

@section('content')

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 mb-6">

    <div class="p-6 border-b">
        <h2 class="text-xl font-bold">
            Status Gm Bot 1 - 50
        </h2>
    </div>

    <div class="p-6">

        <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-10 gap-3">

            @for($i = 1; $i <= 50; $i++)

                @php
                    $exists = in_array($i, $existingNumbers);
                @endphp

                <div class="rounded-xl border p-4 text-center
                    {{ $exists
                        ? 'bg-green-50 border-green-300 text-green-700'
                        : 'bg-red-50 border-red-300 text-red-700' }}">

                    <div class="font-bold text-lg">
                        {{ $i }}
                    </div>

                    <div class="text-xs">
                        Gm Bot
                    </div>

                </div>

            @endfor

        </div>

    </div>

</div>

@if(count($otherAccounts))
<div class="bg-white rounded-2xl shadow-sm border border-slate-200">

    <div class="p-6 border-b">
        <h2 class="text-xl font-bold">
            Akun Non Bot
        </h2>

        <p class="text-slate-500 text-sm mt-1">
            Akun yang tidak menggunakan format "Gm Bot".
        </p>
    </div>

    <div class="p-6">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

            @foreach($otherAccounts as $account)

                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">

                    <div class="font-semibold text-blue-700">
                        {{ $account }}
                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>
@endif
@endsection