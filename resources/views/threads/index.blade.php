@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach($threads as $thread)
                        <article>
                            <a href="{{ route('threads.show', [
                                'channel' => $thread->channel->slug, 
                                'thread' => $thread
                            ]) }}">
                                {{ $thread->title }}
                            </a>
                            <div class="body">{{ $thread->body }}</div>
                        </article>
                    @endforeach
                </div>
                {{ $threads->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
