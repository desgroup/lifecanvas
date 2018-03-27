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
                <h3>{{ $byteCount }} lifebytes</h3>
                <div class="row">
                    <div class="col">
                        <div class="row masonry-container" id="items">

                            @foreach($bytes as $byte)
                                @if($byte->asset_id > 0)
                                    @include('byte.partials.image')
                                @endif
                            @endforeach

                        </div>
                        {{  $bytes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->

@endsection

@section('onPageCSS')
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

            var $grid = $('#items').masonry({ itemSelector: '.item' });
            var msnry = $grid.data('masonry');

            $('#items').infiniteScroll({
                path: '/bytes/images?page=@{{#}}',
                append: '.item',
                history: false,
                outlayer: msnry
            });
        })();

    </script>
@endsection