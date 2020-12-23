<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? config('app.name')}}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @livewireStyles
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body class="antialiased bg-gray-50">
    {{ $slot }}

    @livewireScripts
    @stack('scripts')
</body>
</html>
