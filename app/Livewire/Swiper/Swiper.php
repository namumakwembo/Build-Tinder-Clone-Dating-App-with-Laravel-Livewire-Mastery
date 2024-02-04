<?php

namespace App\Livewire\Swiper;

use App\Models\Swipe;
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

        Swipe::create([
            'user_id'=>auth()->id(),
            'swiped_user_id'=>$user->id,
            'type'=>$type
        ]);


    }

    public function render()
    {
        $users= User::limit(10)->whereNotSwiped()->where('id','<>',auth()->id())->get();
        return view('livewire.swiper.swiper',['users'=>$users]);
    }
}
