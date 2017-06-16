@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $byte->title }}</div>

                    <div class="panel-body">
                        <div class="body">{{ $byte->story }}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($byte->comments as $comment)
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ $comment->owner->name }}">{{ $comment->owner->name }}</a> at {{ $comment->created_at->diffForHumans() }}
                    </div>

                    <div class="panel-body">
                        <div class="body">{{ $comment->body }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
