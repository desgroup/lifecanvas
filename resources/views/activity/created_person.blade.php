@component('activity.activity')
    @slot('heading')
        {{ $profileUser->username }} created person: <a href="/perple/{{ $activity->subject->id }}">
            {{ $activity->subject->name }}
        </a>
    @endslot

    @slot('body')

    @endslot
@endcomponent