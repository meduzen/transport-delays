<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="color-scheme" content="dark light only">
    <title>@yield('title', 'STIB Open Data exploration')</title>
    @vite([
        'resources/css/base.css',
        'resources/css/app.css',
    ])
</head>
<body>

@yield('content')

</body>
</html>
