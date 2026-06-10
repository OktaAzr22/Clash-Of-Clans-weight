@props([
    'type' => 'success'
])

@php

$styles = [

    'success' =>
        'bg-green-50 border-green-200 text-green-800',

    'danger' =>
        'bg-red-50 border-red-200 text-red-800',

    'warning' =>
        'bg-yellow-50 border-yellow-200 text-yellow-800',

    'info' =>
        'bg-blue-50 border-blue-200 text-blue-800',

];

@endphp

<div
    class="alert-message
           border
           rounded-lg
           px-4
           py-3
           shadow-sm
           flex
           items-center
           justify-between
           opacity-0
           -translate-y-3
           transition-all
           duration-300
           {{ $styles[$type] ?? $styles['success'] }}"
>

    <span>
        {{ $slot }}
    </span>

    <button
        type="button"
        class="close-alert ml-4 text-lg font-bold opacity-60 hover:opacity-100"
    >
        ×
    </button>

</div>