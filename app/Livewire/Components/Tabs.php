<?php

namespace App\Livewire\Components;

use App\Models\Conversation;
use App\Models\SwipeMatch;
use Livewire\Component;

class Tabs extends Component
{


    protected $listeners=['new-message-created'=>'$refresh'];
    public $selectedConversationId;

    function mount()  {

        $this->selectedConversationId= request()->chat;
        
    }

    public function createConversation(SwipeMatch $match)
    {
        $receiver = $match->swipe1->user_id == auth()->id() ? $match->swipe2->user : $match->swipe1->user;

        $conversation= Conversation::updateOrCreate(['match_id' => $match->id], 
                                     ['sender_id' => auth()->id(), 
                                     'receiver_id' => $receiver->id]);

        #redirect to conversation
        $this->redirect(route('chat',$conversation->id),navigate:true);
    }

    public function render()
    {
        $matches = auth()->user()->matches()->get();
        $conversations= auth()->user()->conversations()->latest('updated_at')->get();
        return view('livewire.components.tabs', ['matches' => $matches,'conversations'=>$conversations]);
    }
}
