<?php

namespace App\Livewire\Swiper;

use App\Models\Conversation;
use App\Models\Swipe;
use App\Models\SwipeMatch;
use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

class Swiper extends Component
{
    public $users;

    #[Locked]
    public $currentMatchId;

    #[Locked]
    public $swipedUserId;

    #[On('swipedright')]
    function swipedRight(User $user)  {

        abort_unless(auth()->check(),401);

        if ($user !=null) {
            #create swipe right 
            $this->createSwipe($user,'right');
            
        }
    }

    #[On('swipedleft')]
    function swipedleft(User $user)  {

        abort_unless(auth()->check(),401);

        if ($user !=null) {
            #create swipe right 
            $this->createSwipe($user,'left');
            
        }
    }

    #[On('swipedup')]
    function swipedUp(User $user)  {

        abort_unless(auth()->check(),401);

        if ($user !=null) {
            #create swipe right 
            $this->createSwipe($user,'up');
            
        }
    }

    protected function createSwipe($user,$type){

        #remove element from collection
        $this->users = $this->users->reject(function ($item) use ($user) {
            return $item->id === $user->id;
        });
        

         #reset properties 
         $this->reset('swipedUserId','currentMatchId');

        //return null if user is already swiped 
        if (auth()->user()->hasSwiped($user)) {
            return null;
        }

       $swipe=  Swipe::create([
            'user_id'=>auth()->id(),
            'swiped_user_id'=>$user->id,
            'type'=>$type
        ]);

        #check if type if super like or swipe right 
        if ($type=='up'||$type=='right') {

            $authUserId=auth()->id();
            $this->swipedUserId=$user->id;


            #now if swiped user also swiped on authenticated user 
            $matchingSwipe= Swipe::where('user_id',$this->swipedUserId)
                                    ->where('swiped_user_id',$authUserId)
                                    ->whereIn('type',['up','right'])
                                    ->first();
            
            #if true then create a match
            if ($matchingSwipe) {
               $match= SwipeMatch::create([
                    'swipe_id_1'=>$swipe->id,
                    'swipe_id_2'=>$matchingSwipe->id
                ]);
                # code...
                 //show match found
            $this->dispatch('match-found');

            $this->currentMatchId=$match->id;



            }



           
        }


    }

    public function createConversation(){

        $conversation= Conversation::create([
            'sender_id'=>auth()->id(),
            'receiver_id'=>$this->swipedUserId,
            'match_id'=>$this->currentMatchId,
        ]);


        //dispatch an event
        $this->dispatch('close-match-modal');

        #reset properties 
        $this->reset('swipedUserId','currentMatchId');

        #redirect to conversation
        $this->redirect(route('chat',$conversation->id),navigate:true);


    }
    function mount()  {



        $this->users= User::limit(10)->whereNotSwiped()->where('id','<>',auth()->id())->get();


        
    }

    public function render()
    {

        return view('livewire.swiper.swiper');
    }
}
