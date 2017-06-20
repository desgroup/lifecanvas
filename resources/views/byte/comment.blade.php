<div class="panel panel-default">
    <div class="panel-heading">
        <a href="{{ $comment->owner->username }}">{{ $comment->owner->username }}</a> at {{ $comment->created_at->diffForHumans() }}
    </div>

    <div class="panel-body">
        <div class="body">{{ $comment->body }}</div>
    </div>
</div>
