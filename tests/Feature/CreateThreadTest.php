<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    public function test_guest_user_cannot_create_thread()
    {
        // review guest cannot create thread
        
        $this->assertGuest($guard = null);
        $thread = factory('App\Thread')->make();
        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect(route('login'));
    }

    public function test_guest_user_cannot_access_create_thread_page()
    {
        $this->assertGuest($guard = null);
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_thread()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->make();
        
        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect(route('threads.show', [
                'channel' => $thread->channel,
                'thread' => Thread::where('title', $thread->title)->first(),
            ])); 

        $this->get(route('threads.show', [
            'channel' => $thread->channel,
            'thread' => Thread::where('title', $thread->title)->first(),
        ]))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_thread_requires_title()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->make(['title' => null]);

        $this->post(route('threads.store'), $thread->toArray())
            ->assertSessionHasErrors('title');
    }

    public function test_thread_requires_title_and_body()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->make(['title' => null, 'body' => null]);

        $this->post(route('threads.store'), $thread->toArray())
            ->assertSessionHasErrors([
                'title',
                'body',
            ]);
    }

    public function test_thread_requires_existing_channel()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->make(['channel_id' => 5]);

        $this->post(route('threads.store'), $thread->toArray())
            ->assertSessionHasErrors(['channel_id']);
    }
}
