@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">All Bytes</div>

                    <div class="panel-body">
                        @foreach($bytes as $byte)
                            <article><h4><a href="/bytes/{{ $byte->id }}">{{ $byte->title }}</a></h4></article>
                            <div class="body">{{ $byte->story }}</div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
