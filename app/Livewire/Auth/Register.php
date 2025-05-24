<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name, $email, $phone, $password, $language;

    protected $rules = [
        'name' => 'required|string|min:3',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|string',
        'password' => 'required|min:6',
        'language' => 'nullable|string',
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
            'reputation_points' => 0,
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.app');
    }
}
