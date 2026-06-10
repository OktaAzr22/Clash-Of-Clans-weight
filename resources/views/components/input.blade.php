@props([
    'name',
    'label',
    'type' => 'text'
])

<div class="mb-4">

    <label
        for="{{ $name }}"
        class="block text-sm font-medium text-slate-700 mb-2"
    >
        {{ $label }}
    </label>

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name) }}"

        {{ $attributes->merge([
            'class' => '
                w-full
                px-4
                py-2
                border
                border-slate-300
                rounded-lg
                focus:outline-none
                focus:ring-2
                focus:ring-blue-500
                focus:border-blue-500
            '
        ]) }}
    >

    @error($name)
        <p class="mt-1 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror

</div>