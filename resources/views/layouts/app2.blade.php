<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="viewport"
              content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="theme-color" content="#333">
        <meta name="description" content="Material Style Theme">

        <title>{{ config('app.name', 'Lifecanvas') }}</title>

        <!-- Styles -->

        <link rel="stylesheet" href="/assets/font-awesome/css/fontawesome-all.min.css">
        <link rel="stylesheet" href="/fonts/iconmoon/style.css">

        <style>
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

            body {
                padding-bottom: 100px;
            }
        </style>

        @yield('css_page')
        @yield('head_js')

        @yield('headcontent')

        <link rel="shortcut icon" href="/assets/material/assets/img/favicon.png?v=3">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="/assets/material/assets/css/preload.min.css">
        <link rel="stylesheet" href="/assets/material/assets/css/plugins.min.css">
        <link rel="stylesheet" href="/assets/material/assets/css/style.material.min.css">
        <!--[if lt IE 9]>
            <script src="/assets/material/assets/js/html5shiv.min.js"></script>
            <script src="/assets/material/assets/js/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <div id="app">

            <div id="ms-preload" class="ms-preload">
                <div id="status">
                    <div class="spinner">
                        <div class="dot1"></div>
                        <div class="dot2"></div>
                    </div>
                </div>
            </div>

            <div class="ms-site-container">

                @if(!isset($hidenav))
                    @include('layouts.partials.nav2')
                @endif

                @yield('content')

                <div>

                </div>

                <flash message="{{ session('flash') }}"></flash>

                <div class="btn-back-top">
                    <a href="#" data-scroll id="back-top"
                       class="btn-circle btn-circle-primary btn-circle-sm btn-circle-raised ">
                        <i class="zmdi zmdi-long-arrow-up"></i>
                    </a>
                </div>
            </div>

            @include('layouts.partials.sidenav')

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

        <script src="/assets/material/assets/js/plugins.min.js"></script>
        <script src="/assets/material/assets/js/app.min.js"></script>

    </body>
</html>