@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="page-header">
                    <h1>
                        {{ $profileUser->username }}
                    </h1>
                    <h3>Lifer since: {{ $profileUser->created_at->diffForHumans() }}</h3>
                </div>
                @foreach($activities as $date => $activityGroup)
                    <h3 class="page-header">{{ $date }}</h3>
                    @foreach($activityGroup as $activity)
                        @if(view()->exists("activity.{$activity->type}"))
                            @include("activity.{$activity->type}")
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection