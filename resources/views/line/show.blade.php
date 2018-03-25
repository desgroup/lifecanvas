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
                                <a href="/lines/{{ $line->id }}" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-view-list"></i> Timeline
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-camera"></i> Images
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-pin"></i>Map
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h2 style="text-transform: uppercase;">{{ $line->name }}</h2>
                <h3>{{ $byteCount }} lifebytes</h3>
                <ul class="ms-timeline" id="items">
                    @foreach($bytes as $byte)
                        @include('byte.partials.card')
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <!-- container -->

@endsection

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
                path: '/lines/{{ $line->id }}?page=@{{#}}',
                append: '.item',
                history: false
            });
        })();

    </script>
@endsection