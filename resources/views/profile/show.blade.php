@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>
                {{ $profileUser->username }}
            </h1>
            <h3>Lifer since: {{ $profileUser->created_at->diffForHumans() }}</h3>
        </div>
        @foreach($bytes as $byte)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <span class="flex">
                            <a href="/bytes/{{ $byte->id }}">{{ $byte->title }}</a> posted:
                        </span>
                        <span>{{ $byte->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="body">{{ $byte->story }}</div>
                </div>
            </div>
        @endforeach
        {{ $bytes->links() }}
    </div>
@endsection