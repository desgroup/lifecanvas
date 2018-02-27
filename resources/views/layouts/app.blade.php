<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lifecanvas') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/assets/font-awesome/css/font-awesome.min.css">
    <style>
        body { padding-bottom: 100px; }
        .level { display: flex; justify-content: flex-end; }
        .flex { flex: 1; }
        .mt-1 { margin-top: 1em; }
        .mr-1 { margin-right: 1em; }
        .ml-1 { margin-left: 1em; }
        .mb-1 { margin-bottom: 1em; }

        .mt-2 { margin-top: 2em; }
        .mr-2 { margin-right: 2em; }
        .ml-2 { margin-left: 2em; }
        .mb-2 { margin-bottom: 2em; }

        .btn-primary {
            background-color: #A8DA17;
            border-color: #A8DA17;
        }

    </style>

    @yield('css_page')
    @yield('head_js')

    @yield('headcontent')

</head>
<body style="padding-bottom: 100px;">
<div id="app">

    @if(!isset($hidenav))
        @include('layouts.partials.nav')
    @endif

    @yield('content')
    <flash message="{{ session('flash') }}"></flash>
</div>

@yield('onPageCSS')

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
@yield('js_scripts')
</body>
</html>
