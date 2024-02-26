<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Swipe;
use App\Models\User;
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


      $users= \App\Models\User::factory(200)->create();

           $testUser= \App\Models\User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

     // $testUser= User::where('email','test@example.com')->first();

        #create swipes for our test user

        foreach ($users as $key => $user) {
            
            Swipe::factory()->create(['user_id'=>$user->id,'swiped_user_id'=>$testUser->id]);
        }

    }
}
