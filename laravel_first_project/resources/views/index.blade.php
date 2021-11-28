<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="root-container">
            @auth
                @yield('content-app')
            @else
                @yield('content-auth')
            @endauth
        </div>
        {{-- <div>Index file</div> --}}
    </body>
</html>
