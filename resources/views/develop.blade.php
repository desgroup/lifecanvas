@extends('layouts.app')

@section('css_page')
    <style>
        #map {
            height: 250px;
            width: 100%;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h3>My Google Maps Demo</h3>
                <div id="map"></div>
            </div>
        </div>
    </div>

@endsection

@section('js_scripts')
    <script>
        function initMap() {
            var uluru = {lat: {{ $lat }}, lng: {{ $lng }}};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
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
