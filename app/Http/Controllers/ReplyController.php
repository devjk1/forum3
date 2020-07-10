<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Thread;
use App\Reply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    public function store(Request $request, Thread $thread)
    {
        // $validator = Validator::make($request->all(), [
        //     // 'user_id' => 'required',
        //     'thread_id' => 'required',
        //     'body' => 'required',
        // ])->validate();

        $newReply = new Reply();
        $newReply->user_id = Auth::id();
        $newReply->thread_id = $thread->id;
        $newReply->body = $request->body;
        $newReply->save();

        return redirect()->route('threads.show', compact('thread'));
    }
}
