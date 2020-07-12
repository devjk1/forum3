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
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_create_thread()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);

        $thread = factory('App\Thread')->make();    // simulate a form
        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect(route('threads.show', Thread::where('title', $thread->title)->first()));
            
        $this->get(route('threads.show', Thread::where('title', $thread->title)->first()))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
