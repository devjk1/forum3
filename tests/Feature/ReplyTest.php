<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_reply_has_an_owner()
    {
        $reply = factory('App\Reply')->create();
        
        $this->assertInstanceOf('App\User', $reply->user);
    }
}
