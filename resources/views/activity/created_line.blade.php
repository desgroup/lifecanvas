@component('activity.activity')
    @slot('heading')
        {{ $profileUser->name }} created lifeline: <a href="/lines/{{ $activity->subject->id }}">
            {{ $activity->subject->name }}
        </a>
    @endslot

    @slot('body')

    @endslot
@endcomponent