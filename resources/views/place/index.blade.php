@extends('layouts.app2')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2">
            </div>
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Places</h3>
                    </div>
                    <div class="panel-body">
                        @forelse($places as $place)
                            <article><h4><a href="/places/{{ $place->id }}">{{ $place->name }}</a></h4></article>
                            <hr>
                        @empty
                            <p>You have no places. <a href="/places/create">Add a place.</a></p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
