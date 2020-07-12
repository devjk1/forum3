<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_authenticated_user_can_reply_to_a_thread()
    {
        $user = factory('App\User')->create();
        $this->be($user);

        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->create(['thread_id' => $thread]);
        $this->post(route('replies.store', $thread));

        $this->get(route('threads.show', $thread))
            ->assertSee($reply->body);
    }
}
