@component('activity.activity')
    @slot('heading')
        {{ $profileUser->name }} favorited: <a href="{{ $activity->subject->byte->path() }}">
            {{ $activity->subject->byte->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->byte->body }}
    @endslot
@endcomponent