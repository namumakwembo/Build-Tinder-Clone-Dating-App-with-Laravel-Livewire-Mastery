<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use Livewire\Component;

class Chat extends Component
{
    public $chat;
    public $conversation;
    public $receiver;


    function mount()  {

        #check auth
        abort_unless(auth()->check(),401);


        #get conversation
        $this->conversation= Conversation::findOrFail($this->chat);

        #Check belongs to conversation
        $belongsToConversation = auth()->user()->conversations()
                                 ->where('id',$this->chat)
                                 ->exists();
        abort_unless($belongsToConversation,403);

        #set receiever
        $this->receiver= $this->conversation->getReceiver();
                                 

        
    }


    public function render()
    {
        return view('livewire.chat.chat');
    }
}
