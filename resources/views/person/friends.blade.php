@extends('layouts.app2')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-lg-12 ms-paper-content-container">
                <div class="ms-paper-content">
                    <h1>My Friends</h1>
                    <h3>Number of friends: {{ $friends->count() }}</h3>
                    <section class="ms-component-section">
                        <div class="row">
                            @foreach($friends as $rr)
                                @php ($friend = $rr->sender->id == Auth::user()->id ? $rr->recipient : $rr->sender)
                                <div class="col-md-3">
                                    <div class="card">
                                        <a href="/{{ $friend->username }}">
                                            <div class="image-container" style="display: flex; align-items: center; justify-content: center; background-color: #F2F2F2">
                                                @if(is_null($friend->avatar))
                                                    <i class="icon-byte-icon2" style="font-size: 100px; color: #87cb12; "></i>
                                                @else
                                                    <img src="/usr/{{ $friend->id }}/avatar/{{ $friend->avatar }}avatar.jpg" alt="" class="img-fluid">
                                                @endif
                                            </div>
                                        </a>
                                        <div class="card-body text-center">
                                            <form method="POST" action="/unfriend/{{ $friend->username }}">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn-circle btn-circle-success btn-circle-raised btn-card-float right wow zoomInDown index-2" data-toggle="tooltip" data-placement="top" title="Un-Friend">
                                                    <i class="fa fa-users"></i>
                                                </button>
                                            </form>
                                            <h4 class="color-primary"><a href="/{{ $friend->username }}">{{ '@' . ($friend->username) }}</a></h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- container -->

@endsection

@section('onPageCSS')

    <style type="text/css">
        .image-container {
            height: 12em;
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
