@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $thread->title }}</div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
        @foreach($thread->replies as $reply)
            @include('threads.reply')
        @endforeach
        </div>
    </div>
    @if(Auth::check())
    <div class="row justify-content-center">
        <div class="col-md-8">
            <form method="post" action="{{ route('reply.store', ['thread' => $thread]) }}">
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
        </div>
    </div>
    @else
    <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
    @endif
</div>
@endsection
