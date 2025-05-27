<?php

namespace App\Livewire\Pages\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profile extends Component
{
    public $user, $tools, $isOwnProfile;
    
    public function mount($id = null){
        if($id){
            $this->user = User::findOrFail($id);
        }else{
            $this->user = Auth::user();
        }
        $this->isOwnProfile = Auth::id() === $this->user->id;
        $this->tools = $this->user->tools()->get();
    }
    public function render()
    {
        return view('livewire.pages.auth.profile')->layout('layouts.app');
    }
}
