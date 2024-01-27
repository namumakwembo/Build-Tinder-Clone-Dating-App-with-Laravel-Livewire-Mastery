<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tinder Clone</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body
    style="background-image: url(' {{asset('assets/tinder_hero_image.webp')}} '); background-size:cover; background-attachment:fixed"
     class="antialiased">
        <div class="relative min-h-screen bg-black/40 flex flex-col">
            @if (Route::has('login'))
                @include('livewire.layout.navigation')
            @endif


            <center class="m-auto flex flex-col gap-y-10">

                <h3 class="font-bold text-7xl sm:text-8xl text-white">
                    Swipe Right

                    <sup>
                        <span class="text-xl p-2 px-3 border-4 rounded-full border-white">
                            R
                        </span>
                    </sup>
                </h3>


                <a class="rounded-3xl bg-gradient-to-r from-pink-500 via-orange-500 to-rose-500 text-white text-xl font-bold px-8 py-2.5 max-w-fit mx-auto " href="{{route('register')}}">
                    Create account
                </a>



            </center>

          
        </div>

        {{-- Testimonials  --}}
        <main class="bg-white w-full  px-8 lg:px-24 py-9 mx-auto">

            <section class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">


                @for ($i = 0; $i < 5; $i++)

                <div class="border rounded-lg p-3 h-96 shadow overflow-hidden">
                    <div class="flex justify-between items-center">

                        <h5 class="font-bold my-3"> {{fake()->name}} </h5>

                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-quote w-10 h-10 text-gray-700" viewBox="0 0 16 16">
                            <path d="M12 12a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1h-1.388q0-.527.062-1.054.093-.558.31-.992t.559-.683q.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 9 7.558V11a1 1 0 0 0 1 1zm-6 0a1 1 0 0 0 1-1V8.558a1 1 0 0 0-1-1H4.612q0-.527.062-1.054.094-.558.31-.992.217-.434.559-.683.34-.279.868-.279V3q-.868 0-1.52.372a3.3 3.3 0 0 0-1.085.992 4.9 4.9 0 0 0-.62 1.458A7.7 7.7 0 0 0 3 7.558V11a1 1 0 0 0 1 1z"/>
                          </svg>

                    </div>

                    <hr class="font-bold my-2">

                    <p> {{fake()->sentence(50) }} </p>

               </div>
               @endfor

            </section>


        </main>

        @livewireScripts
    </body>
</html>
