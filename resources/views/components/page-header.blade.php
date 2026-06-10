@php

$routeName = request()->route()?->getName();

$title = 'Dashboard';

$breadcrumbs = [];

if ($routeName) {

    $parts = explode('.', $routeName);

    $resource = $parts[0] ?? null;
    $action = $parts[1] ?? null;

    $resourceName = ucfirst(
        str($resource)
            ->replace('_', ' ')
            ->singular()
    );

    $breadcrumbs[] = [
        'label' => 'Dashboard',
        'url' => route('dashboard')
    ];

    if ($resource) {

        $breadcrumbs[] = [
            'label' => $resourceName,
            'url' => route($resource . '.index')
        ];

        $title = $resourceName;
    }

    switch ($action) {

        case 'create':
            $title = "Tambah {$resourceName}";
            $breadcrumbs[] = [
                'label' => 'Tambah'
            ];
            break;

        case 'edit':
            $title = "Edit {$resourceName}";
            $breadcrumbs[] = [
                'label' => 'Edit'
            ];
            break;

        case 'show':
            $title = "Detail {$resourceName}";
            $breadcrumbs[] = [
                'label' => 'Detail'
            ];
            break;
    }

}

@endphp

<header class="bg-white/80 backdrop-blur-md border-b border-slate-200/70">

    <div class="px-6 py-4 flex items-center justify-between">

        <div>

            <h1 class="text-xl font-bold text-slate-800">
                {{ $title }}
            </h1>

            <nav class="text-sm mt-1">

                <ol class="flex items-center">

                    @foreach($breadcrumbs as $breadcrumb)

                        <li class="flex items-center">

                            @if(!$loop->last)

                                <a
                                    href="{{ $breadcrumb['url'] }}"
                                    class="text-slate-500 hover:text-blue-600 transition"
                                >
                                    {{ $breadcrumb['label'] }}
                                </a>

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-3 w-3 mx-2 text-slate-400"
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

                            @else

                                <span
                                    class="font-medium text-blue-600"
                                >
                                    {{ $breadcrumb['label'] }}
                                </span>

                            @endif

                        </li>

                    @endforeach

                </ol>

            </nav>

        </div>

        @isset($actions)

            <div class="flex items-center gap-2">

                {{ $actions }}

            </div>

        @endisset

    </div>

</header>