@props([
    'variant' => 'primary',
    'type' => 'button',
    'loading' => false,
    'loadingText' => 'Memproses...'
])

@php

$variants = [

    'primary' =>
        'bg-blue-600 hover:bg-blue-700 text-white',

    'secondary' =>
        'bg-slate-200 hover:bg-slate-300 text-slate-800',

    'success' =>
        'bg-green-600 hover:bg-green-700 text-white',

    'danger' =>
        'bg-red-600 hover:bg-red-700 text-white',

    'warning' =>
        'bg-yellow-500 hover:bg-yellow-600 text-white',

];



$classes = $variants[$variant] ?? $variants['primary'];

@endphp

<button
    type="{{ $type }}"
    data-loading="{{ $loading ? 'true' : 'false' }}"
    data-loading-text="{{ $loadingText }}"
    {{ $attributes->merge([
        'class' => "
            btn-loading
            inline-flex
            items-center
            justify-center
            gap-2
            px-4
            py-2
            rounded-lg
            font-medium
            transition
            duration-200
            {$classes}
        "
    ]) }}
>

    <span class="btn-text">
        {{ $slot }}
    </span>

    @if($loading)

        <svg
            class="btn-spinner hidden animate-spin h-4 w-4"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
        >
            <circle
                class="opacity-25"
                cx="12"
                cy="12"
                r="10"
                stroke="currentColor"
                stroke-width="4"
            ></circle>

            <path
                class="opacity-75"
                fill="currentColor"
                d="M4 12a8 8 0 018-8v8z"
            ></path>

        </svg>

    @endif

</button>