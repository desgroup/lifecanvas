@component('activity.activity')
    @slot('heading')
        {{ $profileUser->name }} commented on lifebyte: <a href="{{ $activity->subject->byte->path() }}">
            {{ $activity->subject->byte->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent