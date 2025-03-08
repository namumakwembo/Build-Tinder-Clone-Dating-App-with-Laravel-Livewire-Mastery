<div 
x-data="{
    height:0,
    conversationElement:document.getElementById('conversation')

}"

x-init="
    height= conversationElement.scrollHeight;
    $nextTick(()=>conversationElement.scrollTop=height);

    Echo.private('users.{{auth()->id()}}')
    .notification((notification) => {
       if(notification['type']=='App\\Notifications\\MessageSentNotification' && notification['conversation_id']=={{$conversation->id}})
       {

        $wire.listenBroadcastedMessage(notification);

       }
    })

"


@scroll-bottom.window="

$nextTick(()=>{

    conversationElement.style.overflowY='hidden';

    conversationElement.scrollTop= conversationElement.scrollHeight;

    conversationElement.style.overflowY='auto';


});

"
class="flex h-screen overflow-hidden">

    <main class="w-full grow border flex flex-col relative">

        {{-- header --}}
        <header class="flex items-center gap-2.5 p-2 border">
            {{-- return button --}}
            <a class="sm:hidden" wire:navigate href="{{route('chat.index')}}">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-chevron-left w-6 h-6" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    </svg>
                </span>
            </a>

            <x-avatar />

            <h5 class="font-bold text-gray-500 truncate">
                {{$receiver->name}}
            </h5>

            <div class="ml-auto flex items-center gap-2 px-2">

                {{-- Dots --}}
                <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-three-dots text-gray-500 w-7 h-7" viewBox="0 0 16 16">
                        <path
                            d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3" />
                    </svg>

                </span>


                {{-- cancel button --}}
                <a href="{{route('app')}}">

                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-x-octagon-fill text-gray-500 w-7 h-7" viewBox="0 0 16 16">
                            <path
                                d="M11.46.146A.5.5 0 0 0 11.107 0H4.893a.5.5 0 0 0-.353.146L.146 4.54A.5.5 0 0 0 0 4.893v6.214a.5.5 0 0 0 .146.353l4.394 4.394a.5.5 0 0 0 .353.146h6.214a.5.5 0 0 0 .353-.146l4.394-4.394a.5.5 0 0 0 .146-.353V4.893a.5.5 0 0 0-.146-.353zm-6.106 4.5L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708" />
                        </svg>
                    </span>
                </a>

            </div>

        </header>

        {{-- body --}}
        <section

        @scroll="
        scrollTop = $el.scrollTop;
        console.log(scrollTop);

        if(scrollTop<=0){

            @this.dispatch('loadMore');
        }
        
        "

        @update-height.window="
        $nextTick(()=>{

            newHeight =$el.scrollHeight;
            oldHeight= height;

            $el.scrollTop= newHeight - oldHeight;

            height= newHeight;


        });
        
        "


        id="conversation"
            class="flex flex-col gap-2 overflow-auto h-full p-2.5 overflow-y-auto flex-grow overflow-x-hidden w-full my-auto">

             @foreach ($loadedMessages as $message)
                 
          
                @php 
                $belongsToAuth=$message->sender_id==auth()->id();
                @endphp

                <div
                 wire:ignore
                 @class([ 'max-w-[85%] md:max-w-[78%] flex w-auto gap-2 relative mt-2' , 'ml-auto'=>$belongsToAuth

                    ]) >

                    {{-- Avatar --}}
                    <div @class(['shrink-0 mt-auto','invisible'=>$belongsToAuth])>
                        {{-- <x-avatar class="w-7 h-7" src="https://xsgames.co/randomusers/assets/avatars/female/'{{ $message->sender_id }}.jpg" /> --}}
                    </div>

                    {{-- Message body --}}

                    <div @class(['flex flex-wrap text-[15px] border border-gray-200/40 rounded-xl p-2.5 flex flex-col
                       ', 
                        'bg-red-500 text-white'=>$belongsToAuth,
                        'text-black bg-white'=>!$belongsToAuth
                        ])>

                        <p class="whitespace-normal text-sm md:text-base tracking-wide lg:tracking-normal">
                           {{$message->body}}
                        </p>

                    </div>



                </div>

                @endforeach

        </section>

        {{-- footer --}}
        <footer class="sticky bottom py-2 inset-x-0 border-t bg-gray-50  p-2">

            <form x-data="{body:@entangle('body')}" @submit.prevent="$wire.sendMessage()" autocomplete="off">
                @csrf
                {{-- hidden input --}}
                <input type="hidden" autocomplete="false" style="display: none">

                <div class="grid grid-cols-12 items-center">
                    {{-- spotify --}}
                    <span class="col-span-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-spotify w-8 h-8 text-gray-500" viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.669 11.538a.5.5 0 0 1-.686.165c-1.879-1.147-4.243-1.407-7.028-.77a.499.499 0 0 1-.222-.973c3.048-.696 5.662-.397 7.77.892a.5.5 0 0 1 .166.686m.979-2.178a.624.624 0 0 1-.858.205c-2.15-1.321-5.428-1.704-7.972-.932a.625.625 0 0 1-.362-1.194c2.905-.881 6.517-.454 8.986 1.063a.624.624 0 0 1 .206.858m.084-2.268C10.154 5.56 5.9 5.419 3.438 6.166a.748.748 0 1 1-.434-1.432c2.825-.857 7.523-.692 10.492 1.07a.747.747 0 1 1-.764 1.288" />
                        </svg>

                    </span>

                    <input x-model="body" type="text" autocomplete="off" autofocus placeholder="Write your message here"
                        maxlength="1700"
                        class="col-span-9 bg-gray-100 border-0 outline-0 focus:border-0 focus:ring-0 hover:ring-0 rounded-lg focus:outline-none">

                    <button x-bind:disabled="!body?.trim()" type="submit" class="col-span-2">
                        Send
                    </button>


                </div>


            </form>

        </footer>

    </main>

    {{-- profile section --}}
    <aside class="w-[50%] hidden sm:flex border">

        <div style="contain: content"
            class=" inset-0 overflow-y-auto overflow-hidden overscroll-contain  w-full  bg-white space-y-4">

            @php
                $slides=['https://xsgames.co/randomusers/assets/avatars/female/'.rand(0,79).'.jpg','https://xsgames.co/randomusers/assets/avatars/female/'.rand(0,79).'.jpg','https://xsgames.co/randomusers/assets/avatars/female/'.rand(0,79).'.jpg']

            @endphp

            {{-- Carousel section --}}
            <section class="relative  h-96" x-data="{activeSlide:1, slides:@js($slides)}">

                {{-- Slides --}}
                <template x-for="(image,index) in slides" :key="index">
                    <img x-show="activeSlide===index + 1" :src="image" alt="image"
                        class="absolute inset-0 pointer-events-none w-full h-full object-cover">

                </template>

                {{-- pagination --}}
                <div draggable="true" :class="{'hidden':slides.length==1}"
                    class="absolute top-1 inset-x-0 z-10 w-full flex items-center justify-center">

                    <template x-for="(image,index) in slides" :key="index">

                        <button @click="activeSlide=index+1"
                            :class="{'bg-white':activeSlide===index +1,'bg-gray-500':activeSlide !== index+1}"
                            class="flex-1 w-4 h-2 mx-1 rounded-full overflow-hidden">

                        </button>
                    </template>


                </div>

                {{-- Prev button --}}
                <button draggable="true" :class="{'hidden':slides.length==1}"
                    @click="activeSlide = activeSlide ===1? slides.length:activeSlide-1"
                    class="absolute left-2 top-1/2 my-auto ">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>


                </button>

                {{-- Next button --}}
                <button draggable="true" :class="{'hidden':slides.length==1}"
                    @click="activeSlide = activeSlide === slides.length ? 1 : activeSlide +1"
                    class="absolute right-2 top-1/2 my-auto ">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="w-6 h-6 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </button>



            </section>


            {{-- profile information --}}

            <section class="grid gap-4 p-3">

                <div class="flex items-center text-3xl gap-3 text-wrap">
                    <h3 class="font-bold"> {{$receiver->name}} </h3>
                    <span class="font-semibold text-gray-800">
                        {{$receiver->age}}
                    </span>
                </div>

                {{-- about --}}

                <ul>
                    <li class="items-center text-gray-600 text-lg">
                        {{$receiver->profession}}
                    </li>
                    <li class="items-center text-gray-600 text-lg">
                        {{$receiver->height?$receiver->height.' cm':''}}
                    </li>
                    <li class="items-center text-gray-600 text-lg">
                        Lives in Spain
                        {{$receiver->city?'Lives in '.$receiver->city:''}}
                    </li>
                </ul>

                <hr class="-mx-2.5">

                {{-- bio --}}

                <p class="text-gray-600">
                    {{$receiver->about}}
                </p>

                {{-- Relatioship goals --}}
                <div class="rounded-xl bg-green-200 h-24 px-4 py-2 max-w-fit flex gap-4 items-center">

                    <div class="text-3xl"> 👋 </div>
                    <div class="grid w-4/5">
                        <span class="font-bold text-sm text-green-800">Looking for </span>
                        <span class="text-lg text-green-800 capitalize"> {{str_replace('_','
                            ',$receiver->relationship_goals?->value)}} </span>

                    </div>
                </div>

                {{-- More information --}}

                <section class="divide-y space-y-2">

                    @if ($receiver->languages)

                    <div class="spacey-y-3 py-2">
                        <h3 class="font-bold text-xl py-2"> Languages i know </h3>
                        <ul class="flex flex-wrap gap-3">
                            @foreach ($receiver->languages as $language )
                            <li class="border border-gray-500 rounded-2xl text-sm px-2.5 p-1.5 capitalize">
                                {{$language->name}}</li>
                            @endforeach


                        </ul>
                    </div>
                    @endif

                    @if ($receiver->basics)
                    <div class="spacey-y-3 py-2">
                        <h3 class="font-bold text-xl py-2"> Basics </h3>
                        <ul class="flex flex-wrap gap-3">
                            @foreach ($receiver->basics as $basic )
                            <li class="border border-gray-500 rounded-2xl text-sm px-2.5 p-1.5">{{$basic->name}}
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    @endif

                    <div class="spacey-y-3 py-2">
                        <h3 class="font-bold text-xl py-2"> Lifestyle </h3>
                        <ul class="flex flex-wrap gap-3">
                            <li class="border border-gray-500 rounded-2xl text-sm px-2.5 p-1.5">Non Smoker</li>
                            <li class="border border-gray-500 rounded-2xl text-sm px-2.5 p-1.5">Gym</li>
                            <li class="border border-gray-500 rounded-2xl text-sm px-2.5 p-1.5">Travel</li>
                        </ul>
                    </div>

                </section>


                <button wire:confirm='are you sure '  wire:click="deleteMatch" class="py-6 border-y flex flex-col gap-2 text-gray-500 justify-center text-center items-center">

                    <span class="font-bold">
                        Unmatch
                    </span>
                    <span>
                        No longer interested?, remove them from your matches
                    </span>
                </button>





            </section>



        </div>
    </aside>



</div>