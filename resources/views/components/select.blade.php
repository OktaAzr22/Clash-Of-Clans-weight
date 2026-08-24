@props([
    'name',
    'label' => null,
    'required' => false
])

<div class="mb-4">

    @if($label)

        <label
            for="{{ $name }}"
            class="block text-sm font-medium text-slate-700 mb-2"
        >
            {{ $label }}

            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>

    @endif

    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}

        {{ $attributes->merge([
            'class' => '
                w-full
                px-4
                py-2
                border
                border-slate-300
                rounded-lg
                bg-white
                focus:outline-none
                focus:ring-2
                focus:ring-blue-500
                focus:border-blue-500
            '
        ]) }}
    >
        {{ $slot }}
    </select>

    @error($name)

        <p class="mt-1 text-sm text-red-500">
            {{ $message }}
        </p>

    @enderror

</div>