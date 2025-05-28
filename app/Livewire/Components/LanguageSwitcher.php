<?php

namespace App\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Livewire\Component;

class LanguageSwitcher extends Component
{
    public $language;
    public function mount(){
            $this->language = Auth::user()->language ?? 'en';
    }
    public function updatedLanguage($value){
        $user = Auth::user();
        if ($user->language !== $value) {  
            $user->language = $value;
            $user->save();
            App::setLocale($value);
        }
        $this->dispatch('languageChanged');
    }
    public function render()
    {
        return view('livewire.components.language-switcher');
    }
}
