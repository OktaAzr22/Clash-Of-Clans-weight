<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @livewireStyles
</head>
<body class="bg-gray-100">

    {{ $slot }}

    @livewireScripts
</body>
</html>