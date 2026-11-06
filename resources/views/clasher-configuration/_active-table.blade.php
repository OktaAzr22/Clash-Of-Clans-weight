<div class="overflow-x-auto">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-5 py-3 text-left">#</th>
                <th class="px-5 py-3 text-left">Akun</th>
                <th class="px-5 py-3 text-left">Clan</th>
                <th class="px-5 py-3 text-center">TH</th>
                <th class="px-5 py-3 text-center">Status</th>
                <th class="px-5 py-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody class="divide-y">
            @forelse ($clashers as $clasher)
                <tr
                    class="hover:bg-gray-50 transition"
                    data-clasher-id="{{ $clasher->id }}"
                >
                    <td class="px-5 py-4 text-gray-500">
                        {{ $clashers->firstItem() + $loop->index }}
                    </td>

                    <td class="px-5 py-4">
                        <div class="font-medium text-gray-800">
                            {{ $clasher->name }}
                        </div>

                        <div class="text-xs text-gray-400 mt-1">
                            {{ $clasher->tag }}
                        </div>
                    </td>

                    <td class="px-5 py-4 text-gray-600">
                        {{ $clasher->clan_name ?? '-' }}
                    </td>

                    <td class="px-5 py-4 text-center">
                        <span class="font-semibold">
                            TH {{ $clasher->town_hall }}
                        </span>
                    </td>

                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center gap-2 text-green-600">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            Aktif
                        </span>
                    </td>

                    <td class="px-5 py-4">
                        <div class="flex justify-center">
                            <form
                                action="{{ route('configuration.toggle-active', $clasher) }}"
                                method="POST"
                                class="toggle-active-form"
                            >
                                @csrf
                                @method('PATCH')

                                <x-button
                                    type="submit"
                                    variant="danger"
                                    class="!px-2.5 !py-2"
                                    title="Nonaktifkan akun"
                                >
                                    <span class="button-content inline-flex items-center">
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
                                                d="M18.364 5.636A9 9 0 1 1 5.636 18.364M12 8v4"
                                            />

                                            <circle
                                                cx="12"
                                                cy="16"
                                                r=".5"
                                                fill="currentColor"
                                            />
                                        </svg>
                                    </span>

                                    <span class="loading-content hidden items-center">
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
                                    </span>
                                </x-button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td
                        colspan="6"
                        class="px-5 py-10 text-center text-gray-500"
                    >
                        Tidak ada akun aktif.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($clashers->hasPages())
    <div class="px-5 py-4 border-t">
        {{ $clashers->links() }}
    </div>
@endif