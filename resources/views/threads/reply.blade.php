<div class="card">
    <div class="card-header">
        <a href="">
            {{ $reply->user->name }}
        </a>
        replied {{ $reply->created_at->diffForHumans() }}...
    </div>

    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>