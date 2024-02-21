<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\SwipeMatch;
use App\Notifications\MessageSentNotification;
use Livewire\Attributes\On;
use Livewire\Component;

class Chat extends Component
{
    public $chat;
    public $conversation;
    public $receiver;

    public $body;

    public $loadedMessages;
    public $paginate_var=10;


    function listenBroadcastedMessage($event)  {


        $this->dispatch('scroll-bottom');

        $newMessage = Message::find($event['message_id']);


        #push messsage
        $this->loadedMessages->push($newMessage);

        #mark message as read
        $newMessage->read_at= now();
        $newMessage->save();

        #refresh chat list 

        $this->dispatch('new-message-created');





        
    }

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

         #dispatch event to scroll chat to bottom
         $this->dispatch('scroll-bottom');

         #push the message
         $this->loadedMessages->push($createdMessage);

         #update the conversation model
         $this->conversation->updated_at=now();
         $this->conversation->save();

         #dispatch event
         $this->dispatch('new-message-created');

         #broadcast out message
         $this->receiver->notify(new MessageSentNotification(auth()->user(),$createdMessage,$this->conversation));

    }


    #[On('loadMore')]
    function loadMore()  {

        #increment
        $this->paginate_var +=10;

        #call the loadMessages()
        $this->loadMessages();

        #dispatch event
        $this->dispatch('update-height');

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


    function deleteMatch()  {

        abort_unless(auth()->check(),401);

        #make sure user belongs to match
        $belongsToMatch = auth()->user()->matches()->where('swipe_matches.id',$this->conversation->match_id)->exists();
        abort_unless($belongsToMatch,403);

        #delete match 
        SwipeMatch::where('id',$this->conversation->match_id)->delete();

        #redirect
        $this->redirect(route('chat.index'),navigate:true);
        
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


        #mark messages as read
        Message::where('conversation_id',$this->conversation->id)
                      ->where('receiver_id',auth()->id())
                      ->whereNull('read_at')
                      ->update(['read_at'=>now()]);

        #set receiever
        $this->receiver= $this->conversation->getReceiver();

        $this->loadMessages();
                                 

        
    }


    public function render()
    {
        return view('livewire.chat.chat');
    }
}
