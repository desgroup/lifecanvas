@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ $byte->title }}</h3><br>
                        <a href="@if($byte->creator->username == Auth::user()->username)
                                /bytes">
                            @else
                                /{{ $byte->creator->username }}">
                            @endif
                            {{ $byte->creator->username }}</a>
                        at {{ $byte->created_at->diffForHumans() }}
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
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
@endsection
