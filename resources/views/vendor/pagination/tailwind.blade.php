@if ($paginator->hasPages())
    <div class="flex items-center justify-between px-6 py-4 border-t border-slate-200 bg-slate-50">

        {{-- Info data --}}
        <p class="text-sm text-slate-600">
            Menampilkan
            {{ $paginator->firstItem() }}
            -
            {{ $paginator->lastItem() }}
            dari
            {{ $paginator->total() }}
            data
        </p>

        {{-- Pagination --}}
        <div class="flex gap-2">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="px-3 py-1 rounded-lg border bg-slate-100 text-slate-400 cursor-not-allowed">
                    Prev
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                class="px-3 py-1 rounded-lg border text-slate-600 hover:bg-slate-100">
                    Prev
                </a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)

                {{-- Dots --}}
                @if (is_string($element))
                    <span class="px-3 py-1 text-slate-400">
                        ...
                    </span>
                @endif

                {{-- Array pages --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)

                        @if ($page == $paginator->currentPage())
                            <span class="px-3 py-1 rounded-lg bg-blue-600 text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="px-3 py-1 rounded-lg border text-slate-600 hover:bg-slate-100">
                                {{ $page }}
                            </a>
                        @endif

                    @endforeach
                @endif

            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                class="px-3 py-1 rounded-lg border text-slate-600 hover:bg-slate-100">
                    Next
                </a>
            @else
                <span class="px-3 py-1 rounded-lg border bg-slate-100 text-slate-400 cursor-not-allowed">
                    Next
                </span>
            @endif

        </div>

    </div>
@endif