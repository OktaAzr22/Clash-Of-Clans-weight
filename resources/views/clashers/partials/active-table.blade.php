<div class="overflow-x-auto">

    <table class="w-full text-sm">

        <thead>

              <tr class="bg-slate-50/80 border-b border-slate-200">

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Akun

                    </th>

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Clan 

                    </th>

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        TH 

                    </th>

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Status 

                    </th>

                    <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                        Template
                    </th>

                    <th class="text-center px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">

                        Action

                    </th>

                </tr>

        </thead>
        
        <tbody class="divide-y divide-slate-100">

            @forelse ($clashers as $clasher)
            
              <tr class="hover:bg-slate-50/60 transition duration-150">

                        <td class="px-6 py-4 font-semibold text-slate-700">

                            <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold border border-indigo-200">

                                {{ $clasher->name }}

                            </span>

                        </td>

                        <td class="px-6 py-4 font-medium text-slate-800">

                            {{ $clasher->tag }}

                        </td>

                        <td class="px-6 py-4 text-slate-600">

                            {{ $clasher->clan_name ?? '-' }}

                        </td>

                        <td class="px-6 py-4 text-slate-500 text-xs">

                            TH {{ $clasher->town_hall }}

                        </td>

                        <td class="px-6 py-4">
                            @if ($clasher->template)
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-purple-50 text-purple-700 border border-purple-200 text-xs font-semibold">
                                    <i class="fa-solid fa-layer-group text-purple-500"></i>

                                    {{ $clasher->template->name }}
                                </span>
                            @else
                                <span class="text-xs text-slate-400">
                                    Belum ada
                                </span>
                            @endif
                        </td>

                        <td class="px-5 py-4">
                            <div class="flex justify-center">

                                <form
                                    action="{{ route(
                                        'configuration.toggle-active',
                                        $clasher
                                    ) }}"
                                    method="POST"
                                    class="toggle-active-form"
                                >
                                    @csrf
                                    @method('PATCH')

                                    <button
                                        type="submit"
                                        title="Nonaktifkan akun"
                                        class="
                                            px-2.5
                                            py-2
                                            bg-red-600
                                            hover:bg-red-700
                                            text-white
                                            rounded-lg
                                            transition
                                            duration-200
                                            active:scale-95
                                        "
                                    >
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
                                                d="M18.364 5.636 A9 9 0 1 1 5.636 18.364 M12 8v4"
                                            />

                                            <circle
                                                cx="12"
                                                cy="16"
                                                r=".5"
                                                fill="currentColor"
                                            />
                                        </svg>
                                    </button>

                                </form>

                            </div>
                        </td>

              </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="
                            px-5
                            py-10
                            text-center
                            text-gray-500
                        "
                    >
                        Tidak ada akun aktif.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@if ($clashers->hasPages())

    <div
        id="active-pagination"
        
    >

        {{ $clashers->links() }}

    </div>

@endif