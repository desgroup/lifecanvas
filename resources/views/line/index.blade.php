@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">My Lifelines</h3>
                    </div>
                    <div class="panel-body">
                        @forelse($lines as $line)
                            <article><h4><a href="/lines/{{ $line->id }}">{{ $line->name }}</a></h4></article>
                            <hr>
                        @empty
                            <p>You have no lifelines. <a href="/lines/create">Add a lifeline.</a></p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
