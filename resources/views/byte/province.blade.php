@extends('layouts.app2')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="">{{ $province->province_name_en }}, {{ $province->country_code }} lifebytes</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="hidden-sm hidden-xs">
                    <hr class="mt-1 mb-1">
                    <ul class="menu-box">
                        <li class="menu-item">{{ $byteCount . " " . str_plural('lifebyte', $byteCount)}}</li>
                        <li class="menu-item"><a href="/bytes/country/{{ $code }}/{{ $province->province_code }}"><i class="zmdi zmdi-view-list"></i> Timeline</a></li>
                        <li class="menu-item"><a href="/bytes/images/country/{{ $code }}/{{ $province->province_code }}"><i class="zmdi zmdi-camera"></i> Images</a></li>
                        <li class="menu-item"><a href="/map/{{ $code }}/{{ $province->province_code }}"><i class="zmdi zmdi-pin"></i> Map</a></li>
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

        <div class="row">
            <div class="col-lg-9">
                <ul class="ms-timeline">
                    <li class="ms-timeline-item wow materialUp">
                        @foreach($bytes as $byte)
                            @include('byte.partials.card')
                        @endforeach
                    </li>
                    <li>
                        {{ $bytes->links() }}
                    </li>
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

            width: 100%;
            overflow: hidden;
            resize: both;
        }
        .image-container img {
            object-fit: contain;

            width: 100%;
        }
    </style>
@stop
