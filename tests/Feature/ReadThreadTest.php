<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
        $response = $this->get(route('threads.show', $this->thread));
        $response->assertSee($this->thread->title);
    }

    public function test_user_can_read_replies_of_a_thread()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread]);
        $response = $this->get(route('threads.show', $this->thread));
        $response->assertSee($reply->body);
    }

    public function test_thread_has_replies()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread]);
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    public function test_thread_has_an_owner()
    {
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf('App\User', $this->thread->user);
    }

    public function test_thread_belongs_to_channel()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }
}