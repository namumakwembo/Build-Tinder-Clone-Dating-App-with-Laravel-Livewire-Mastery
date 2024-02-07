<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Tabs extends Component
{
    public function render()
    {
         $matches= auth()->user()->matches()->get();
        return view('livewire.components.tabs',['matches'=>$matches]);
    }
}
