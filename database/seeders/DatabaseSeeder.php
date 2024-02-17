<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Swipe;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BasicSeeder::class,
            LanguageSeeder::class
        ]);


       $users= \App\Models\User::factory(10)->create();

       $testUser= \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        #create swipes for our test user

        foreach ($users as $key => $user) {
            
            Swipe::factory()->create(['user_id'=>$user->id,'swiped_user_id'=>$testUser->id]);
        }

    }
}
