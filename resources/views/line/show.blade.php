@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $line->name }}</h3>
                    </div>
                    <div class="panel-body">
                        @forelse($bytes as $byte)
                            <article><h4><a href="/bytes/{{ $byte->id }}">{{ $byte->title }}</a></h4></article>
                            <div class="body">{{ $byte->story }}</div>
                            <hr>
                        @empty
                            <p>There are no bytes in this lifeline.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
            </div>
        </div>
    </div>
@endsection
