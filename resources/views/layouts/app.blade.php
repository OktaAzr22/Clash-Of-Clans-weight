<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="bg-gray-100" data-old-modal="{{ old('modal') }}">

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <x-alert type="success">
                {{ session('success') }}
            </x-alert>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            <x-alert type="danger">
                {{ session('error') }}
            </x-alert>
        </div>
    @endif

    @yield('content')

    

</body>
</html>