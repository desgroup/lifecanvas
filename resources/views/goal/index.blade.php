@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2>All lifegoals</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="hidden-sm hidden-xs">
                    <hr class="mt-1 mb-1">
                    <ul class="menu-box">
                        <li class="menu-item">
                            @if(app('request')->input('filter') == "completed")
                                {{ $goalCompletedCount }} completed
                            @elseif (app('request')->input('filter') == "uncompleted")
                                {{ $goalCount - $goalCompletedCount }} uncompleted
                            @else
                                {{ $goalCount . " " . str_plural('lifegoal', $goalCount)}} ({{ $goalCompletedCount }} completed)
                            @endif
                        </li>
                        <li class="menu-item"><a href="/goals"><i class="fa fa-check-circle"></i> All Goals</a></li>
                        <li class="menu-item"><a href="/goals?filter=completed"><i class="fa fa-check-circle"></i> Completed Goals</a></li>
                        <li class="menu-item"><a href="/goals?filter=uncompleted"><i class="fa fa-check-circle-o"></i> Uncompleted Goals</a></li>
                        <li class="menu-item"><a href="/goals/create"><i class="zmdi zmdi-plus"></i> Add a Goal</a></li>
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
                <div id="items">
                    @foreach($goals as $goal)
                        @include('goal.item')
                    @endforeach
                </div>
            </div>
            <div class="col-lg-3">
                @include('adverts.sidebar')
            </div>
        </div>
    </div>
    <!-- container -->
@endsection

@section('css_page')
    <style>

    </style>
@endsection

@section('onPageCSS')
    <style>
        .checkbox-container {
            display: flex;
            align-items: center;
        }

        .image-container2 img {
            object-fit: cover;
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
                path: "/goals?page=@{{#}}&filter={{ app('request')->input('filter') }}",
                append: '.item',
                history: false
            });
        })();

    </script>
@endsection