<?php

namespace App\Livewire\Pages\Home;

use Livewire\Component;

class HomePage extends Component
{
    public function render()
    {
        return view('livewire.pages.home.home-page')->layout('layouts.app');
    }
}
