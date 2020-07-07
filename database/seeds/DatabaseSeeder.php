<?php

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
        
        $threads = factory(App\Thread::class, 10)->create();
        foreach($threads as $thread) {
            $users = $threads->map(function ($thread) {
                return $thread->user;
            });
            foreach($users as $user) {
                $user->replies()->save(factory(App\Reply::class)->make(['user_id' => $user, 'thread_id' => $thread]));
            }
        }
    }
}
