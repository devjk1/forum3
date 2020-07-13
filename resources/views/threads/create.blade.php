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
                                class="form-control"
                                name="title"
                                id="title"
                                placeholder="Enter a title"    
                            >
                        </div>
                        <div class="form-group">
                            <label for="body">Body</label>
                            <textarea 
                                name="body" 
                                id="body" 
                                cols="8" 
                                rows="8" 
                                class="form-control"
                            ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="channel">Channel</label>
                            <select 
                                name="channel_id" 
                                id="channel_id"
                            >
                                @foreach($channels as $channel)
                                <option value="{{ $channel->id }}">
                                    {{ $channel->slug }}
                                </option>
                                @endforeach
                            </select>
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
