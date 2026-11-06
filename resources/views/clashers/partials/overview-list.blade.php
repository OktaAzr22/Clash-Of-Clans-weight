@if($clashers->isEmpty())

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 py-16">
        <div class="flex flex-col items-center">
            <i class="fa-regular fa-folder-open text-5xl text-slate-300 mb-4"></i>
            <p class="text-slate-500">Tidak ada data clasher.</p>
        </div>
    </div>

@else

    @foreach($clashers as $clasher)

        @php
            $groupedBuildings = $clasher->clasherBuildings
                ->groupBy(fn ($item) => $item->building->name);

            $maxRows = $groupedBuildings->map(fn ($items) => $items->count())->max();
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-6">

            <div class="p-6 border-b border-slate-200">

                <h3 class="text-xl font-bold text-slate-800">
                    {{ $clasher->name }}
                </h3>

                <p class="text-sm text-slate-500">{{ $clasher->tag }}</p>

            </div>

            <div class="p-6">

                <div class="overflow-x-auto">

                    <table class="min-w-full text-sm">

                        <thead>
                            <tr class="bg-slate-100">
                                <th class="px-4 py-3 sticky left-0 bg-slate-100">Slot</th>

                                @foreach($groupedBuildings as $name => $items)
                                    <th class="px-4 py-3 text-center">{{ $name }}</th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody>

                            @for($row = 0; $row < $maxRows; $row++)
                                <tr class="hover:bg-slate-50">

                                    <td class="px-4 py-3 sticky left-0 bg-white">
                                        #{{ $row + 1 }}
                                    </td>

                                    @foreach($groupedBuildings as $items)
                                        @php
                                            $level = $items->values()[$row]->level ?? null;
                                        @endphp

                                        <td class="px-4 py-3 text-center">
                                            @if($level)
                                                <span class="px-2 py-1 bg-blue-50 text-blue-700 rounded-lg">
                                                    {{ $level }}
                                                </span>
                                            @else
                                                —
                                            @endif
                                        </td>
                                    @endforeach

                                </tr>
                            @endfor

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endforeach

@endif