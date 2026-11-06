@forelse ($inactiveClashers as $clasher)

    <div
        data-clasher-id="{{ $clasher->id }}"
        class="
            inactive-row
            flex
            items-center
            justify-between
            px-4
            py-4
            border-b
            border-slate-100
            transition-all
            duration-300
            hover:bg-slate-50
        "
    >

        <div class="min-w-0">

            <div class="flex items-center gap-2">

                <div class="font-medium text-slate-800 truncate">
                    {{ $clasher->name }}
                </div>

                <span
                    class="
                        inline-flex
                        items-center
                        gap-1
                        px-2
                        py-0.5
                        rounded-full
                        bg-red-50
                        text-red-600
                        text-xs
                        font-medium
                    "
                >
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                    Nonaktif
                </span>

            </div>

            <div class="text-sm text-slate-500 mt-1">
                {{ $clasher->tag }}

                <span class="mx-1 text-slate-300">•</span>

                TH {{ $clasher->town_hall }}
            </div>

            <div class="text-xs text-slate-400 mt-1">
                {{ $clasher->clan_name ?? '-' }}
            </div>

            <div class="text-xs text-slate-400 mt-2">
                Terakhir aktif:
                <span class="font-medium text-slate-500">
                    {{ $clasher->updated_at?->locale('id')->diffForHumans() ?? '-' }}
                </span>
            </div>

        </div>

        <form
            action="{{ route('configuration.toggle-active', $clasher) }}"
            method="POST"
            class="toggle-active-form ml-4 flex-shrink-0"
        >
            @csrf
            @method('PATCH')

            <x-button
                type="submit"
                variant="success"
                class="!px-3 !py-2"
            >

                <span class="button-content inline-flex items-center gap-2">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14m-7-7 7 7-7 7"
                        />
                    </svg>

                    Aktifkan
                </span>

                <span class="loading-content hidden items-center gap-2">
                    <svg
                        class="w-4 h-4 animate-spin"
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
                        />

                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v8z"
                        />
                    </svg>

                    Memproses...
                </span>

            </x-button>
        </form>

    </div>

@empty

    <div class="py-12 text-center">

        <div
            class="
                mx-auto
                mb-3
                flex
                h-12
                w-12
                items-center
                justify-center
                rounded-full
                bg-slate-100
            "
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-slate-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9Z"
                />
            </svg>
        </div>

        <p class="text-sm font-medium text-slate-700">
            Tidak ada akun nonaktif
        </p>

        <p class="text-xs text-slate-400 mt-1">
            Semua akun saat ini dalam keadaan aktif.
        </p>

    </div>

@endforelse