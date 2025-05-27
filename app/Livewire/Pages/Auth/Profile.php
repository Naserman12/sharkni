<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public $user, $tools;
    public function mount(){
            $this->user = Auth::user();
            $this->tools = $this->user->tools()->get();
    }
    public function render()
    {
        return view('livewire.pages.auth.profile')->layout('layouts.app');
    }
}
