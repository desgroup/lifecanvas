@component('activity.activity')
    @slot('heading')
        {{ $profileUser->username }} favorited:
        <a href="{{ $activity->subject->favorited->path() }}">
            {{ $activity->subject->favorited->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->story }}
    @endslot
@endcomponent