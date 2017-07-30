@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">My People</h3>
                    </div>
                    <div class="panel-body">
                        @forelse($people as $person)
                            <article><h4><a href="/people/{{ $person->id }}">{{ $person->name }}</a></h4></article>
                            <hr>
                        @empty
                            <p>You have no people. <a href="/people/create">Add a person.</a></p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
