<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function test_user_can_browse_threads()
    {
        $response = $this->get(route('threads.index'));
        $response->assertSee($this->thread->title);
        // $response->assertStatus(200);
    }

    public function test_user_can_browse_a_thread()
    {
        $response = $this->get(route('threads.show', [
            'channel' => $this->thread->channel,
            'thread' => $this->thread,
        ]));
        $response->assertSee($this->thread->title);
    }

    public function test_user_can_read_replies_of_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread]);
        $response = $this->get(route('threads.show', [
            'channel' => $this->thread->channel,
            'thread' => $this->thread,
        ]));
        $response->assertSee($reply->body);
    }

    public function test_user_can_filter_threads_by_channel()
    {
        $thread1 = factory('App\Thread')->create();
        $thread2 = factory('App\Thread')->create();

        $this->get(route('channels.index', ['channel' => $thread1->channel]))
            ->assertSee($thread1->title)
            ->assertSee($thread1->body)
            ->assertDontSee($thread2->title)
            ->assertDontSee($thread2->body);
    }

    public function test_authorized_user_can_filter_threads_by_creator()
    {
        $user = factory('App\User')->create(['name' => 'John Doe']);
        $this->actingAs($user);

        $threadByJohn = factory('App\Thread')->create(['user_id' => Auth::id()]);
        $threadNotByJohn = factory('App\Thread')->create();

        $this->get('/threads?name=John+Doe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }
}
