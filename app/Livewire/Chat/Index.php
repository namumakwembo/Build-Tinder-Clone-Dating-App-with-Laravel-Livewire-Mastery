<?php

namespace App\Livewire\Chat;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{

    #[Layout('layouts.chat')]
    public function render()
    {
        return view('livewire.chat.index');
    }
}
