@extends('layouts.app2')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12 col-md-6 order-md-1">
                        <div class="card animated fadeInUp animation-delay-7">
                            <div class="ms-hero-bg-primary">
                                @if(!is_null($user->first_name) || !is_null($user->last_name))
                                    <h3 class="color-white index-1 text-center no-m pt-4">{{ $user->first_name . " " . $user->last_name }}</h3>
                                    <div class="color-medium index-1 text-center np-m">{{ "@" . $user->username }}</div>
                                @else
                                    <h3 class="color-white index-1 text-center no-m pt-4">{{ "@" . $user->username }}</h3>
                                @endif
                                @if(is_null($user->avatar))
                                    <img src="/assets/img/silhouette.png" alt="avatar" class="img-avatar-circle">
                                @else
                                    <img src="/usr/{{ $user->id }}/avatar/{{ $user->avatar }}avatar.jpg" alt="avatar" class="img-avatar-circle">
                                @endif
                            </div>
                            <div class="card-block pt-4 text-center">
                                <h4 style="margin-bottom: 0rem" class="color-primary"><i class="fa fa-calendar"></i> Lifer Since</h4>
                                <h4 style="margin-top: 0.5rem">{{ $user->created_at->diffForHumans() }} ({{Carbon\Carbon::parse($user->created_at)->format('d M, Y')}})</h4>
                                @if(isset($aliveTime))
                                    <h4 style="margin-bottom: 0rem" class="color-primary"><i class="fa fa-clock-o"></i> Alive for</h4>
                                    <h4 style="margin-top: 0.5rem">{{ $aliveTime }}</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 order-md-3 order-lg-2">
                        <a href="/{{ $user->username }}/edit"
                           class="btn btn-warning btn-raised btn-block animated fadeInUp animation-delay-12">
                            <i class="zmdi zmdi-edit"></i> Edit Profile</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-sm-4">
                        <a href="/bytes">
                            <div class="card card-success card-block text-center wow zoomInUp animation-delay-2">
                                <h2 class="color-success">{{ $byteCount }}</h2>
                                <span class="icon-byte-icon2" style="font-size: 60px; color: #87cb12;"></span>
                                <p class="mt-2 no-mb lead small-caps color-success">bytes</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="/friends">
                            <div class="card card-info card-block text-center wow zoomInUp animation-delay-5">
                                <h2 class="color-info">{{ $user->getFriendsCount() }}</h2>
                                <i class="fa fa-4x fa-users color-info"></i>
                                <p class="mt-2 no-mb lead small-caps color-info">friends</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-4">
                        <a href="/goals">
                            <div class="card card-royal card-block text-center wow zoomInUp animation-delay-4">
                                <h2 class="color-royal">{{ $goalCount }}</h2>
                                <i class="fa fa-4x fa-check-circle color-royal"></i>
                                <p class="mt-2 no-mb lead small-caps color-royal">goals</p>
                            </div>
                        </a>
                    </div>
                </div>
                <h2 class="color-primary text-center mt-4 mb-2">Byte Feed</h2>
                <div class="row">
                    <div class="col-lg-12" id="news">
                        <ul class="ms-timeline" id="items">
                            <div class="bytelist">
                                @foreach($bytes as $byte)
                                    @include('byte.partials.card')
                                @endforeach
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->

@endsection

@section('onPageCSS')
    <style type="text/css">

        body {
            background-color: #FFFFFF;
            background: #FFFFFF; /* Old browsers */
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
                path: '/feed?page=@{{#}}',
                append: '.item',
                history: false
            });
        })();

    </script>
@endsection


