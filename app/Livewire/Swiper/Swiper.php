<?php

namespace App\Livewire\Swiper;

use App\Models\User;
use Livewire\Component;

class Swiper extends Component
{
    public function render()
    {
        $users= User::limit(10)->get();
        return view('livewire.swiper.swiper',['users'=>$users]);
    }
}
