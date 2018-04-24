@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="">{{ $place->name }} lifebytes</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="hidden-sm hidden-xs">
                    <hr class="mt-1 mb-1">
                    <ul class="menu-box">
                        <li class="menu-item">{{ $byteCount . " " . str_plural('lifebyte', $byteCount)}}</li>
                        <li class="menu-item"><a href="/places/{{ $place->id }}"><i class="zmdi zmdi-view-list"></i> Timeline</a></li>
                        <li class="menu-item"><a href="/places/images/{{ $place->id }}"><i class="zmdi zmdi-camera"></i> Images</a></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                        <li class="menu-item"></li>
                    </ul>
                    <hr class="mt-1 mb-3">
                </div>
            </div>
        </div>
        @if(!is_null($place->image_id) || (!is_null($place->lat) && !is_null($place->lng)))
        <div class="row">
            @if(!is_null($place->image_id))
                @if(!is_null($place->lat) && !is_null($place->lng))
                    <div class="col-lg-9">
                        <div class="heading-container">
                            <img src="/usr/1/medium/15aca4daed23148-52350562.jpg" height="200px" width="100%" class="img-fluid" style="height: 200px; width: 100%; object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12">
                        <div class="heading-container">
                            <img src="/usr/1/medium/15aca4daed23148-52350562.jpg" height="300px" width="100%" class="img-fluid" style="height: 300px; width: 100%; object-fit: cover;">
                        </div>
                    </div>
                @endif
            @else
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        @endif
        <div class="row mt-4">
            <div class="col-lg-9">
                <ul class="ms-timeline" id="items">
                    @foreach($bytes as $byte)
                        @include('byte.partials.card')
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-3">
                @include('adverts.sidebar')
            </div>
        </div>
    </div>
    <!-- container -->
@endsection

@section('onPageCSS')
    <style>
        #map {
            height: 200px;
            width: 100%;
        }

        .menu-box {
            display: flex;
            align-items: stretch; /* Default */
            justify-content: space-around;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .menu-item {
            display: block;
            flex: 0 1 auto; /* Default */
            list-style-type: none;
        }
        .panel-body {
            padding: 1rem 2rem  !important;
        }

        .image-container {
            height: 200px;
            width: 100%;
            overflow: hidden;
            resize: both;
        }

        .image-container img {
            object-fit: contain;
            width: 100%;
        }

        .heading-containerx img {
            position: absolute;
            width: 100%;
            height: 200px;
            clip: inherit;
        }
    </style>
@stop

@section('js_scripts')
    <script src="/js/infinite-scroll-3-0-3.js"></script>
    <script>
        (function(){

            var loading_options = {
                finishedMsg: "<div class='end-msg'>Congratulations! You've reached the end of the internet</div>",
                msgText: "<div class='center'>Loading news items...</div>",
                img: "/assets/img/ajax-loader.gif"
            };

            $('#items').infiniteScroll({
                path: '/places/{{ $place->id }}?page=@{{#}}',
                append: '.item',
                history: false
            });
        })();
    </script>
    <script>
        function initMap() {
            var uluru = {lat: {{ $place->lat }}, lng: {{ $place->lng }}};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: {{ $place->map_zoom ?? 14 }},
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD0b8kHZFV0eqVi_d5a3J2W6QFucKZcY5I&callback=initMap">
    </script>
@endsection
