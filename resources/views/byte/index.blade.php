@extends('layouts.app2')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary animated zoomInUp animation-delay-7">
                            <div class="card-header">
                                <h3 class="card-title">Display lifebytes as . . .</h3>
                            </div>
                            <div class="list-group">
                                <a href="/bytes" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-view-list"></i> Timeline
                                </a>
                                <a href="/bytes/images" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-camera"></i> Images
                                </a>
                                <a href="/map" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-pin"></i>Map
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h2>All Lifebytes</h2>
                <h3>{{ $bytes->count() }} lifebytes</h3>
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

        </div>
    </div>
    <!-- container -->

@endsection

@section('onPageCSS')
@stop
