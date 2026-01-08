<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="RuangRasa - Ruang tenang untuk memahami kehidupan">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RuangRasa')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    @yield('content')
    
    @stack('scripts')
</body>
</html>
