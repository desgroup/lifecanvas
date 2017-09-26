@extends('layouts.app')

@section('content')
    <div class="container">
        @if(!is_null($byte->place))
            @if(!is_null($byte->place->lat) && !is_null($byte->place->lng))
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div id="map"></div>
            </div>
        </div>
            @endif
        @endif
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            @if( !is_null($byte->asset))
                                <div class="col-md-2">
                                    <img src="{{ $byte->thumbnail() }}" class="img-thumbnail">
                                </div>
                                <div class="col-md-6">
                            @else
                                <div class="col-md-8">
                                    @endif
                                <h4>
                                    {{ $byte->title }}<br>
                                    <a href="@if($byte->creator->username == Auth::user()->username)
                                            /">
                                        @else
                                            /{{ $byte->creator->username }}">
                                        @endif
                                        {{ $byte->creator->username }}</a> at {{ $byte->created_at->diffForHumans() }}
                                </h4>
                            </div>
                            <div class="col-md-4">
                                @if($byte->user_id == auth()->id())
                                    <form action="{{ $byte->path() }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-default"> <i class="fa fa-trash"></i> </button>
                                    </form>
                                @endif
                                <form method="POST" action="/bytes/{{ $byte->id }}/favorites">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-default" {{ $byte->isFavorited() ? 'disabled' : ''}}>
                                        {{ $byte->favorites_count }} <i class="fa fa-heart"></i> {{ str_plural('Favorite', $byte->favorites_count) }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="body">{{ $byte->story }}</div>
                        <div class="lines">
                            @foreach($lines as $line)
                                <a href="/lines/{{ $line->id }}">{{ $line->name }}</a> |
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($byte->comments as $comment)
                    @include('byte.comment')
                @endforeach
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <form method="POST" action="{{ $byte->path() . '/comment' }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"
                                  rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@if(!is_null($byte->place))
    @if(!is_null($byte->place->lat) && !is_null($byte->place->lng))
        @section('css_page')
            <style>
                #map {
                    height: 250px;
                    width: 100%;
                }
            </style>
        @endsection

        @section('js_scripts')
            <script>
                function initMap() {
                    var uluru = {lat: {{ $byte->place->lat }}, lng: {{ $byte->place->lng }}};
                    var map = new google.maps.Map(document.getElementById('map'), {
                        zoom: {{ $byte->place->map_zoom }},
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
    @endif
@endif

