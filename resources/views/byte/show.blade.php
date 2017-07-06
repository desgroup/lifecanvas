@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <div class="pull-right">
                                <form method="POST" action="/bytes/{{ $byte->id }}/favorites">
                                    {{ csrf_field() }}
                                    <button type="submit" class="btn btn-default" {{ $byte->isFavorited() ? 'disabled' : ''}}>
                                        {{ $byte->favorites_count }} <i class="fa fa-heart"></i> {{ str_plural('Favorite', $byte->favorites_count) }}
                                    </button>
                                </form>
                            </div>
                            <h4>
                                {{ $byte->title }} <br>
                                <a href="@if($byte->creator->username == Auth::user()->username)
                                        /">
                                    @else
                                        /{{ $byte->creator->username }}">
                                    @endif
                                    {{ $byte->creator->username }}</a> at {{ $byte->created_at->diffForHumans() }}
                            </h4>
                        </div>
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
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?"
                                  rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Comment</button>
                </form>
            </div>
        </div>
    </div>
@endsection
