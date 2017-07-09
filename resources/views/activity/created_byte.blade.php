@component('activity.activity')
    @slot('heading')
        {{ $profileUser->name }} created lifebyte: <a href="{{ $activity->subject->path() }}">
            {{ $activity->subject->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->story }}
    @endslot
@endcomponent