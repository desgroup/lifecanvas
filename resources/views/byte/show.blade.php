@extends('layouts.app')

@section('css_page')

@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">

                @if( !is_null($byte->asset))
                    <img src="{{ $byte->medium() }}" class="img-responsive center-block">
                @endif

            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    @if(!is_null($byte->place))
                        @if(!is_null($byte->place->lat) && !is_null($byte->place->lng))
                            <div id="map"></div>
                        @endif
                    @endif
                    <div class="panel-heading">
                        <h4>{{ $byte->title }}</h4>
                    </div>
                    <div class="panel-body">
                        @if ($byte->place_id > 0)
                            <a href="/places/{{ $place->id }}">{{ $place->name }}</a><br>
                        @endif
                        @if (isset($displayDate))
                            {{ $displayDate }}<br>
                        @endif
                        @if (!is_null($byte->story))
                            <div class="body mt-1">{{ $byte->story }}</div>
                        @endif
                        <div class="lines mt-1">
                        @foreach($lines as $line)
                            <a href="/lines/{{ $line->id }}">{{ $line->name }}</a> |
                        @endforeach
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-6">
                                @include('byte.partials.rating') @include('byte.partials.repeat')<br>
                                Lifer: <a href="@if($byte->creator->username == Auth::user()->username)
                                        /">
                                    @else
                                        /{{ $byte->creator->username }}">
                                    @endif
                                    {{ $byte->creator->username }}</a>
                            </div>
                            <div class="col-md-6">
                                <div class="level">
                                    <form method="POST" action="/bytes/{{ $byte->id }}/favorites">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-default mr-1" data-toggle="tooltip" data-placement="top" title="Favorite this byte" {{ $byte->isFavorited() ? 'disabled' : ''}}>
                                            {{ $byte->favorites_count }} <i class="fa fa-heart"></i>
                                        </button>
                                    </form>
                                    @if($byte->user_id == auth()->id())
                                        <a href="{{ $byte->id }}/edit" class="btn btn-default mr-1" data-toggle="tooltip" data-placement="top" title="Edit this byte"><i class="fa fa-pencil"></i></a>
                                        <form action="{{ $byte->path() }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button type="submit" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Delete this byte"> <i class="fa fa-trash"></i> </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-1">
                    @foreach($byte->comments as $comment)
                        @include('byte.comment')
                    @endforeach
                </div>
                <div class="mt-1">
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
    </div>
@endsection

@if(!is_null($byte->place))
    @if(!is_null($byte->place->lat) && !is_null($byte->place->lng))
        @section('css_page')
            <style>
                #map {
                    height: 200px;
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

