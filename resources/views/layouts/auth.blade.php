<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title') | {{ config('system.title') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ config('system.description') }}" name="description" />
        <meta content="{{ config('system.developer.company') }}" name="developer" />
        <meta content="{{ config('system.developer.name') }}" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

        @include('layouts.partials.styles')
        @stack('styles')
    </head>

    <body>
        <div class="account-pages my-5 pt-sm-5">
            @yield('content')
        </div>

        @include('layouts.partials.scripts')
        @stack('scripts')
    </body>
</html>
