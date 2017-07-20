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
    @can ('update', $comment)
        <div class="panel-footer">
            <form method="POST" action="/comments/{{ $comment->id }}">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
            </form>
        </div>
    @endcan

</div>
