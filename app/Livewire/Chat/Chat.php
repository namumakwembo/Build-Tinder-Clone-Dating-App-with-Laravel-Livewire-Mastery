<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use Livewire\Component;

class Chat extends Component
{
    public $chat;
    public $conversation;
    public $receiver;

    public $body;

    public $loadedMessages;
    public $paginate_var=10;


    function sendMessage()  {
         #check auth
         abort_unless(auth()->check(),401);

         $this->validate(['body'=>'required|string']);

         #create message
         $createdMessage= Message::create([
            'conversation_id'=>$this->conversation->id,
            'sender_id'=>auth()->id(),
            'receiver_id'=>$this->receiver->id,
            'body'=>$this->body
         ]);

         $this->reset('body');

         #push the message
         $this->loadedMessages->push($createdMessage);

         #update the conversation model
         $this->conversation->updated_at=now();
         $this->conversation->save();

         #dispatch event
         $this->dispatch('new-message-created');


    }


    function loadMessages()  {

        #get count
        $count=Message::where('conversation_id',$this->conversation->id)->count();

        #skip and query 
        $this->loadedMessages= Message::where('conversation_id',$this->conversation->id)
                                        ->skip($count- $this->paginate_var)
                                        ->take($this->paginate_var)
                                        ->get();

        return $this->loadedMessages;

        
    }

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

        $this->loadMessages();
                                 

        
    }


    public function render()
    {
        return view('livewire.chat.chat');
    }
}
