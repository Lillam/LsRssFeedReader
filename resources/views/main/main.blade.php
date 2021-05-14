<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $vs->title }}</title>
        <link href="{{ asset('assets/css/application.css') }}" rel="stylesheet" type="text/css" />
        @yield('css')
    </head>
    <body class="{{ Auth::check() ? 'header-in' : '' }}">
        @if (Auth::check())
            @include('main.header')
        @endif
        @if(\Illuminate\Support\Facades\Session::has('message'))
            <div class="flash-message">
                <p>{{ \Illuminate\Support\Facades\Session::get('message') }}</p>
                <a class="close-flash-message">Close</a>
            </div>
        @endif
        @yield('body')
        @if(Auth::check())
            @include('main.footer')
        @endif
        @yield('js')
        <script src="{{ asset('assets/vendor/jquery/jquery.js') }}"></script>
        <script src="{{ asset('assets/js/application.js') }}"></script>
    </body>
</html>
