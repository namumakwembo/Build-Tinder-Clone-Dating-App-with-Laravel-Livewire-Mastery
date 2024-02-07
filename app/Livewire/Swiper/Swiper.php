<?php

namespace App\Livewire\Swiper;

use App\Models\Swipe;
use App\Models\SwipeMatch;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;

class Swiper extends Component
{

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
            $swipedUserId=$user->id;


            #now if swiped user also swiped on authenticated user 
            $matchingSwipe= Swipe::where('user_id',$swipedUserId)
                                    ->where('swiped_user_id',$authUserId)
                                    ->whereIn('type',['up','right'])
                                    ->first();
            
            #if true then create a match
            if ($matchingSwipe) {
                SwipeMatch::create([
                    'swipe_id_1'=>$swipe->id,
                    'swipe_id_2'=>$matchingSwipe->id
                ]);
                # code...
                 //show match found
            $this->dispatch('match-found');



            }



           
        }


    }

    public function render()
    {
        $users= User::limit(10)->whereNotSwiped()->where('id','<>',auth()->id())->get();
        return view('livewire.swiper.swiper',['users'=>$users]);
    }
}
