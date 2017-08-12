<div class="media">
    @if( !is_null($byte->asset))
        <div class="media-left">
            <a href="/bytes/{{ $byte->id }}">
                <img class="media-object" src="{{ $byte->thumbnail() }}" alt="...">
            </a>
        </div>
    @endif
    <div class="media-body">
        <h4 class="media-heading"><a href="/bytes/{{ $byte->id }}">{{ $byte->title }}</a></h4>
        {{ $byte->story }}
    </div>
</div>
<hr>
