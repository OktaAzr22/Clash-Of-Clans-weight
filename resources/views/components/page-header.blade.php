@php

use Illuminate\Support\Facades\Route;

$routeName = request()->route()?->getName();

$showBreadcrumb = $routeName !== 'dashboard';

$title = 'Dashboard';

$breadcrumbs = [
    [
        'label' => 'Dashboard',
        'url' => route('dashboard'),
    ],
];

if ($routeName) {

    $parts = explode('.', $routeName);

    $filteredParts = array_values(
        array_filter($parts, fn ($part) => $part !== 'index')
    );

    foreach ($filteredParts as $index => $part) {

        $label = str($part)
            ->replace(['-', '_'], ' ')
            ->title()
            ->toString();

        $isLast = $index === count($filteredParts) - 1;

        $breadcrumb = [
            'label' => $label,
        ];

        if (! $isLast) {

        if ($index === 0) {

            $route = $part . '.index';

        } else {

            $route = implode(
                '.',
                array_slice($filteredParts, 0, $index + 1)
            );
        }

        if (Route::has($route)) {

            $breadcrumb['url'] = route($route);

        }
    }

        $breadcrumbs[] = $breadcrumb;

        if ($isLast) {

            $title = $label;

        }
    }
}

@endphp

<header
    class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-10 border-b border-slate-200/70"
>
    <div class="px-6 py-4 flex items-center justify-between">

        <div>

            <h1 class="text-xl font-bold text-slate-800">
                {{ $title }}
            </h1>

            <div class="h-5 mt-0.5">
                @if($showBreadcrumb)

                <nav class="text-sm mt-0.5">

                    <ol class="inline-flex items-center space-x-1.5">

                        @foreach($breadcrumbs as $breadcrumb)

                            <li class="flex items-center">

                                @if(!$loop->last && isset($breadcrumb['url']))

                                    <a
                                        href="{{ $breadcrumb['url'] }}"
                                        class="text-slate-500 hover:text-blue-600 transition"
                                    >
                                        {{ $breadcrumb['label'] }}
                                    </a>

                                @else

                                    <span
                                        class="{{ $loop->last
                                            ? 'text-blue-600 font-medium'
                                            : 'text-slate-500' }}"
                                    >
                                        {{ $breadcrumb['label'] }}
                                    </span>

                                @endif

                                @unless($loop->last)

                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-3 h-3 mx-1.5 text-slate-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>

                                @endunless

                            </li>

                        @endforeach

                    </ol>

                </nav>

            @endif
            </div>

            

        </div>

        <div class="flex items-center gap-4">

            @isset($actions)

                <div class="flex items-center gap-2">

                    {{ $actions }}

                </div>

            @endisset

            <div class="flex items-center gap-2">

                <div
                    class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-600 to-indigo-500 flex items-center justify-center text-white text-sm font-bold shadow-md"
                >
                    AD
                </div>

                <span
                    class="hidden sm:inline-block text-sm font-medium text-slate-700"
                >
                    Admin
                </span>

            </div>

        </div>

    </div>
</header>