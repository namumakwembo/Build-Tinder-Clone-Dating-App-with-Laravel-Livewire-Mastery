<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Swipe;
use App\Models\SwipeMatch;
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


        $users = \App\Models\User::factory(200)->create();

        $testUser = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // $testUser= User::where('email','test@example.com')->first();

        #create swipes for our test user

        foreach ($users as $key => $user) {
            if (fake()->randomElement([true, false])) {
                $swipe_1 = Swipe::factory()->create(['user_id' => $user->id, 'swiped_user_id' => $testUser->id]);

                if (fake()->randomElement([true, false])) {
                    # create second swite and match
                    $swipe_2 = Swipe::factory()->create(['user_id' => $testUser->id, 'swiped_user_id' => $user->id]);


                    $match = SwipeMatch::create([
                        'swipe_id_1' => $swipe_1->id,
                        'swipe_id_2' => $swipe_2->id
                    ]);


                    //create conversatino
                    if (fake()->randomElement([true, false])) {

                      $conversation=  $this->createConversation($match,$testUser);


                      for ($i=0; $i <rand(0,20) ; $i++) { 
                        $randomSenderId =fake()->randomElement([$testUser->id,$user->id]);
                        $randomReceiverId =fake()->randomElement([$testUser->id,$user->id]);
                        $this->sendMessage($conversation,$randomSenderId,$randomReceiverId);
                      }
                      //Create Messages
                    }
                }
            }
        }
    }

    public function createConversation(SwipeMatch $match,$test):Conversation
    {
        $receiver = $match->swipe1->user_id == $test->id ? $match->swipe2->user : $match->swipe1->user;

        $conversation= Conversation::updateOrCreate(['match_id' => $match->id], 
                                     ['sender_id' => $test->id, 
                                     'receiver_id' => $receiver->id]);


                                     return $conversation;
    }


    function sendMessage(Conversation $conversation,$sender_id,$receiver_id)  {

        #create message
        $createdMessage= Message::create([
           'conversation_id'=>$conversation->id,
           'sender_id'=>$sender_id,
           'receiver_id'=>$receiver_id,
           'body'=>fake()->realText()
        ]);

        #update the conversation model
        $conversation->updated_at=now();
        $conversation->save();


   }




}
