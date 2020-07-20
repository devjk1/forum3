@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-left">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $thread->title }}</div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>

            @foreach($thread->replies as $reply)
                @include('threads.reply')
            @endforeach

            @if(Auth::check())
            <form method="post" action="{{ route('replies.store', ['channel' => $channel, 'thread' => $thread]) }}">
                @csrf
                <div class="form-group">
                    <textarea 
                        name="body" 
                        id="body" 
                        class="form-control" 
                        placeholder="Have something to say?"
                        cols="30" 
                        rows="10"
                    ></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Post</button>
            </form>
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
            
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    This thread was created {{ $thread->created_at->diffForHumans() }}<br>
                    by <a href="#">{{ $thread->user->name }}</a><br>
                    and has {{ $thread->replies()->count() }}
                    {{ Str::plural('comment', $thread->replies()->count()) }}.
                </div>
            </div>
        </div>
    </div>
    
    
</div>
@endsection
