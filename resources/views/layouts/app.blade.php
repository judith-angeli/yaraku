<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('meta-title')</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/book.js') }}"></script>
    </head>
    <body>
        <div class="container m-auto p-3">
            @yield('content')
        </div>
    </body>
</html>
