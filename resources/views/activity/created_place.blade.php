@component('activity.activity')
    @slot('heading')
        {{ $profileUser->username }} created place: <a href="/places/{{ $activity->subject->id }}">
            {{ $activity->subject->name }}
        </a>
    @endslot

    @slot('body')

    @endslot
@endcomponent