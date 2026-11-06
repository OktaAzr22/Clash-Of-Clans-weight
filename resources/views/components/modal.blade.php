@props([
    'id',
    'title' => '',
    'size' => 'md'
])

@php
    $sizes = [
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl'  => 'max-w-5xl',
        '6xl'  => 'max-w-6xl',
        '7xl'  => 'max-w-7xl',
        'full' => 'max-w-[95vw]',
    ];

    $width = $sizes[$size] ?? 'max-w-md';
@endphp 

<div
    id="{{ $id }}"
    class="modal-overlay fixed inset-0 z-50 invisible opacity-0 transition-all duration-300 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4"
>

    <div
        class="modal-container bg-white rounded-2xl shadow-2xl w-full {{ $width }} scale-95 transition-all duration-300">

        <div class="flex items-center justify-between p-5 border-b">
            <h3 class="text-xl font-semibold text-slate-800">
                {{ $title }}
            </h3>

            <button
                type="button"
                class="close-modal text-slate-400 hover:text-slate-600 text-3xl leading-none">
                &times;
            </button>
        </div>

        <div class="p-5  overflow-y-auto max-h-[70vh]">
            {{ $slot }}
        </div>

        @isset($footer)
    <div class="sticky bottom-0 z-20
                border-t border-slate-200
                bg-white/90 backdrop-blur-md
                p-5
                rounded-b-2xl">
        {{ $footer }}
    </div>
@endisset

    </div>

</div>