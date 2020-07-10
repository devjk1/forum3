<?php

namespace Tests\Feature;

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
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withoutExceptionHandling();
        
        $this->assertGuest($guard = null);
        $thread = factory('App\Thread')->make();
        $this->post(route('threads.store', $thread->toArray()))
            ->assertRedirect(route('login'));
        

        // $this->get($thread->path())
        //     ->assertSee($thread->title)
        //     ->assertSee($thread->body);
    }

    public function test_authenticated_user_can_create_thread()
    {
        $user = factory('App\User')->create();
        $this->actingAs($user);     // $this->be($user);
        
        // $thread_array = factory('App\Thread')->raw(['user_id' => $user]);     // raw returns array like a form
        // $this->post(route('threads.store', $thread_array))

        $thread = factory('App\Thread')->create(['user_id' => $user]);
        $this->post(route('threads.store', $thread->toArray()));

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
