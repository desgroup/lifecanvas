@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $byte->title }}<br>
                        <a href="/{{ $byte->creator->username }}">
                            {{ $byte->creator->username }}
                        </a> at {{ $byte->created_at->diffForHumans() }}
                    </div>
                    <div class="panel-body">
                        <div class="body">{{ $byte->story }}</div>
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
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-default">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
@endsection
