@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-primary animated zoomInUp animation-delay-7">
                            <div class="card-header">
                                <h3 class="card-title">Menu</h3>
                            </div>
                            <div class="list-group">
                                <a href="/lines/" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-view-list"></i> All Goals
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-camera"></i> Completed Goals
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple">
                                    <i class="zmdi zmdi-pin"></i> Open Goals
                                </a>
                                <a href="javascript:void(0)" class="list-group-item list-group-item-action withripple" data-toggle="modal" data-target="#myModal7" >
                                    <i class="zmdi zmdi-plus"></i> Add a Goal
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <h2 style="text-transform: uppercase;">{{ $list->name }}</h2>
                <h3>{{ $goalsCount }} lifeGoals</h3>
                @foreach($goals as $goal)
                    @include('goal.item')
                @endforeach
            </div>
        </div>
    </div>
    @include('goal.form')
    <!-- container -->
@endsection

@section('css_page')
    <style>
        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .image-container img {
            object-fit: cover;
        }
    </style>
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
                path: '/lists/{{ $list->id }}?page=@{{#}}',
                append: '.item',
                history: false
            });
        })();

    </script>
@endsection