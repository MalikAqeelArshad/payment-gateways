<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{-- oncontextmenu="return false" --}}>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Home') | {{ config('app.name') }}</title>

    <!-- Common Font, CSS -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" />

    <!-- Plugin CSS -->
    @stack('pluginCSS')

    <!-- Custom CSS - Public -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Internal CSS -->
    @stack('styles')
    
</head>
<body>
    {{-- @include('layouts.header') --}}

    @yield('content')

    {{-- @include('layouts.footer') --}}

    <!-- jQuery first, then Popper.js and Bootstrap JS Bundle -->
    {{-- <script src="{{ asset('scripts/jquery-3.4.1.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('scripts/bootstrap.bundle.min.js') }}"></script> --}}

    <!-- Plugin JS -->
    @stack('pluginJS')

    <!-- Custom JS - Public -->
    <script src="{{ asset('scripts/public.js') }}"></script>

    <!-- Internal JS -->
    @stack('scripts')

    <!-- Laravel Ajax CSRF Token -->
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
</body>
</html>