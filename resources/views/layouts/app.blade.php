<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    

    <style>
        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: #f1f5f9;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 10px;
        }

        .transition-smooth {
            transition: all .2s ease;
        }
    </style>
</head>

<body
    class="antialiased"
    data-old-modal="{{ old('modal') }}"
>

    @if(session('success'))
        <div class="fixed top-4 right-4 z-50">
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed top-4 right-4 z-50">
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        </div>
    @endif

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Content Area --}}
        <div class="flex-1 flex flex-col overflow-hidden">

            {{-- Header --}}
            <x-page-header />

            {{-- Main Content --}}
            <main class="flex-1 overflow-y-auto p-6">

                @yield('content')

            </main>

        </div>

    </div>

   

</body>
</html>