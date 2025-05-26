<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name = 'gfds', $email, $phone, $password, $language = 'en', $address, $password_confirmation;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email|string|max:255|unique:users,email',
        'phone' => 'required|string:max:15|unique:users',
        'language' => 'required|in:en,ha',
        'password' => 'required|string|min:8|confirmed',
    ];
     public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
            'language' => $this->language,
            'address' => $this->address,
            'reputation_points' => 0,
        ]);

        Auth::login($user);
        return redirect()->route('verification.notict');
    }

    public function render()
    {
        return view('livewire.pages.auth.register')->layout('layouts.app');
    }
}
