<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Channel;
use App\Filters\ThreadFilter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only([
            'create',
            'store',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ThreadFilter $filter)
    {
        $threads = Thread::filter($filter)->paginate(10);

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = Channel::all();
        
        return view('threads.create', compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel_id' => 'required|exists:channels,id',
            'title' => 'required',
            'body' => 'required',
        ]);

        if($validator->fails()) {
            return redirect(route('threads.create'))
                ->withErrors($validator)
                ->withInput();
        }

        $thread = Thread::create([
            'user_id' => Auth::id(),
            'channel_id' => $request->channel_id,
            'title' => $request->title,
            'body' => $request->body,    
        ]);

        return redirect(route('threads.show', [
            'channel' => $thread->channel,
            'thread' => $thread,
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        $replies = $thread->replies()->paginate(10);
        
        return view('threads.show', compact('channel', 'thread', 'replies'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
