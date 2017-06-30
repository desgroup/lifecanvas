<div class="panel panel-default">
    <div class="panel-heading">
        <a href="@if($comment->owner->username == Auth::user()->username)
                    /bytes">
                @else
                    /{{ $comment->owner->username }}">
                @endif
            {{ $comment->owner->username }}</a> at {{ $comment->created_at->diffForHumans() }}
    </div>
    <div class="panel-body">
        <div class="body">{{ $comment->body }}</div>
    </div>
</div>
