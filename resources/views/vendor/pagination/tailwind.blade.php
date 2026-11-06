@if ($paginator->hasPages())
    <div class="flex items-center justify-between px-6 py-4 border-t border-slate-200 bg-slate-50">

        <p class="text-sm text-slate-600">
            Menampilkan
            {{ $paginator->firstItem() }}
            -
            {{ $paginator->lastItem() }}
            dari
            {{ $paginator->total() }}
            data
        </p>

        <div class="flex gap-2">

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

            @php
                $start = max($paginator->currentPage() - 2, 1);
                $end = min($paginator->currentPage() + 2, $paginator->lastPage());
            @endphp

            @if ($start > 1)

                <a href="{{ $paginator->url(1) }}"
                class="px-3 py-1 rounded-lg border text-slate-600 hover:bg-slate-100">
                    1
                </a>

                @if ($start > 2)
                    <span class="px-3 py-1 text-slate-400">
                        ...
                    </span>
                @endif

            @endif

            @for ($page = $start; $page <= $end; $page++)

                @if ($page == $paginator->currentPage())

                    <span class="px-3 py-1 rounded-lg bg-blue-600 text-white">
                        {{ $page }}
                    </span>

                @else

                    <a href="{{ $paginator->url($page) }}"
                    class="px-3 py-1 rounded-lg border text-slate-600 hover:bg-slate-100">
                        {{ $page }}
                    </a>

                @endif

            @endfor

            @if ($end < $paginator->lastPage())

                @if ($end < $paginator->lastPage() - 1)
                    <span class="px-3 py-1 text-slate-400">
                        ...
                    </span>
                @endif

                <a href="{{ $paginator->url($paginator->lastPage()) }}"
                class="px-3 py-1 rounded-lg border text-slate-600 hover:bg-slate-100">
                    {{ $paginator->lastPage() }}
                </a>

            @endif

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