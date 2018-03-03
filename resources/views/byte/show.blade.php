@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            @if( !is_null($byte->asset))
            <div class="col-md-4">
                <a href="{{ $byte->medium() }}" class="img-thumbnail" data-lightbox="image-1" data-title="{{ $byte->title }}">
                    <div class="thumbnail-container">
                        <img src="{{ $byte->medium() }}" class="img-fluid">
                    </div>
                </a>
            @else
            <div class="col-md-2">
            @endif
            </div>
            <div class="col-md-8">
                @if(!is_null($byte->place))
                    @if(!is_null($byte->place->lat) && !is_null($byte->place->lng))
                        <div class="row">
                            <div class="col-md-12">
                                <div id="map"></div>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">{{ $byte->title }}</h4>
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
                                    @if ($lines->count() > 0)
                                        Lines:
                                        @foreach($lines as $line)
                                            <a href="/lines/{{ $line->id }}">{{ $line->name }}</a> |
                                        @endforeach
                                    @endif
                                </div>
                                <div class="people">
                                    @if ($people->count() > 0)
                                        People:
                                        @foreach($people as $person)
                                            <a href="/people/{{ $person->id }}">{{ $person->name }}</a> |
                                        @endforeach
                                    @endif
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-6">
                                        @include('byte.partials.rating')  @include('byte.partials.repeat')<br>
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
                                                <button type="submit" class="btn-circle btn-circle-raised btn-circle-default mr-1" data-toggle="tooltip" data-placement="top" title="Favorite this byte" {{ $byte->isFavorited() ? 'disabled' : ''}}>
                                                    {{ $byte->favorites_count }} <i class="fa fa-heart"></i>
                                                </button>
                                            </form>
                                            @if($byte->user_id == auth()->id())
                                                <a href="{{ $byte->id }}/edit" class="btn-circle btn-circle-raised btn-circle-default mr-1" data-toggle="tooltip" data-placement="top" title="Edit this byte"><i class="fa fa-pencil"></i></a>
                                                    <button type="button" class="btn-circle btn-circle-raised btn-circle-default" data-toggle="modal tooltip" data-placement="top" data-target="#myModal7" title="Delete this byte"> <i class="fa fa-trash"></i> </button>
                                                    <!-- Modal -->
                                                    <div class="modal modal-danger" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel7">
                                                        <div class="modal-dialog animated zoomIn animated-3x" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title" id="myModalLabel7">Are you sure you want to delete this byte?</h3>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">
                                                                          <i class="zmdi zmdi-close"></i>
                                                                        </span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ $byte->title }}</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="{{ $byte->path() }}" method="POST">
                                                                        {{ csrf_field() }}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit" class="btn btn-danger btn-raised" data-toggle="tooltip" data-placement="top" title="Delete this byte"> Delete Byte </button>
                                                                    </form>
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @foreach($byte->comments as $comment)
                            @include('byte.comment')
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{ $byte->path() . '/comment' }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                            <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"
                                      rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-raised btn-success">Add Comment</button>
                        </form>
                    </div>
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
                        zoom: {{ $byte->place->map_zoom ?? 13 }},
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

