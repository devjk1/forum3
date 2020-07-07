<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $threads = factory(App\Thread::class, 100)->create();
        // $threads->each(function ($thread) {
        //     $thread->replies()->saveMany(factory(App\Reply::class, 10)->make(['thread_id' => $thread]));
        // });

        $threads = factory(App\Thread::class, 100)->create();
        $users = User::all();
        foreach($threads as $thread) {
            foreach($users as $user) {
                factory(App\Reply::class)->create(['user_id' => $user, 'thread_id' => $thread]);
            }
        }
    }
}
