@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a new Thread</div>

                <div class="card-body">
                    <form action="{{ route('threads.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input 
                                type="text" 
                                class="form-control @error('title') is-invalid @enderror" required
                                name="title"
                                id="title"
                                placeholder="Enter a title"
                                value="{{ old('title') }}"
                            >
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea 
                                name="body" 
                                id="body" 
                                cols="8" 
                                rows="8" 
                                class="form-control @error('body') is-invalid @enderror" required
                            >{{ old('body') }}</textarea>
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="channel">Channel</label>
                            <select 
                                name="channel_id" 
                                id="channel_id"
                                class="form-control @error('channel_id') is-invalid @enderror" required
                            >
                                <option value="">[Choose a Channel]</option>
                                @foreach($channels as $channel)
                                <option value="{{ $channel->id }}">
                                    {{ $channel->slug }}
                                </option>
                                @endforeach
                            </select>
                            @error('channel_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button 
                            type="submit" 
                            class="btn btn-primary float-md-right"
                        >
                            Publish
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
