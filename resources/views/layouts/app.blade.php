<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/site.webmanifest">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased flex flex-col h-screen">
        <div class="flex flex-1 overflow-hidden">

            {{-- sidebar --}}
            <aside class=" hidden md:flex flex-col bg-gray-100 sm:w-[22rem] w-full">

                <header class="bg-tinder  py-5 flex items-center p-2.5 sticky top-0 ">

                    {{-- avatar --}}

                    <x-avatar class="w-10 h-10" />

                    <div class="ml-auto flex items-center gap-3">

                        <span class="bg-black/40 p-2.5 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-suitcase-lg-fill w-5 h-5 text-white" viewBox="0 0 16 16">
                                <path d="M7 0a2 2 0 0 0-2 2H1.5A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14H2a.5.5 0 0 0 1 0h10a.5.5 0 0 0 1 0h.5a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2H11a2 2 0 0 0-2-2zM6 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zM3 13V3h1v10zm9 0V3h1v10z"/>
                              </svg>
                        </span>

                        <span class="bg-black/40 p-2.5 rounded-full">

                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-fill  w-5 h-5 text-white" viewBox="0 0 16 16">
                                <path d="M5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56"/>
                              </svg>
                        </span>


                    </div>

                </header>

                {{-- Tabs section --}}
                <section 
                 x-data="{ tab:'2' }"
                 class="mb-auto overflow-y-auto overflow-x-scroll relative">

                    <header class="flex items-center gap-5 mb-2 p-4 sticky top-0 bg-white z-10">

                        <button @click="tab='1'"  :class="{ 'border-b-2 border-red-500': tab=='1' }"  class="font-bold text-sm px-2 pb-1.5">
                          Matches
                          <span class="rounded-full text-xs p-1 px-2 font-bold text-white bg-tinder ">
                            12
                          </span>
                        </button>

                        <button @click="tab='2'"  :class="{ 'border-b-2 border-red-500': tab=='2' }"  class="font-bold text-sm px-2 pb-1.5">
                            Messages

                            <span class="rounded-full text-xs p-1 px-2 font-bold text-white bg-tinder ">
                                3
                              </span>
                        </button>

                    </header>

                    <main>

                        {{-- matches --}}
                        <aside class="px-2 " x-show="tab=='1'">
                            <div class="grid grid-cols-3 gap-2">

                                @for ($i = 0; $i < 18; $i++)
                                                   
                                <div class="relative">

                                    {{-- dot --}}
                                    <span class="-top-6 -right-5 absolute">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot text-red-500 w-12 h-12" viewBox="0 0 16 16">
                                            <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                                          </svg>

                                    </span>

                                    <img src=" https://source.unsplash.com/200x200?adult-face-woman-{{$i}}" alt="image" class="h-36 rounded-lg object-cover">

                                    {{-- name --}}

                                    <h5 class="absolute rounded-lg bottom-2 bo left-2 text-white font-bold text-xs">
                                        {{fake()->name}}
                                    </h5>
                                </div>
                                @endfor

                            </div>
                        </aside>

                        {{-- Messages --}}
                        <aside x-cloak  x-show="tab=='2'">
                            <ul>
                                @for ($i = 0; $i < 7; $i++)         
                             
                                <li>
                                    <a 
                                     @class(['flex gap-4 items-center p-2','border-r-4 border-red-500 bg-white py-3'=>$i==3?true:false])
                                      href="#">

                                      <div class="relative">

                                        <span class="inset-y-0 my-auto absolute -right-7">

                                            <svg
                                                @class([
                                                    'w-14 h-14 stroke-[0.3px] stroke-white',
                                                    'hidden'=>$i==3?false:true,
                                                    'text-red-500'=>true
                                                ])

                                            
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"   viewBox="0 0 16 16">
                                                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                                              </svg>

                                        </span>

                                        <x-avatar class="h-14 w-14" src="https://source.unsplash.com/200x200?adult-face-woman-{{$i}}"  />

                                      </div>

                                      <div class="overflow-hidden">
                                        <h6 class="font-bold truncate"> {{fake()->name}} </h6>
                                        <p class="text-gray-600 truncate"> {{fake()->text}} </p>

                                      </div>


                                    </a>

                                </li>
                                @endfor

                            </ul>
                        </aside>


                    </main>

                </section>

            </aside>
 
            <!-- Page Content -->
            <main class="flex-1 flex-col  overflow-y-auto p-5  flex">
                {{ $slot }}
            </main>
        </div>
        @livewireScripts
    </body>
</html>
