<?php

namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $name, $email, $phone, $password, $language = 'en', $address, $password_confirmation;
    protected $rules = [
        'name' => ['required', 'string','min:3','max:255'],
        'email' => ['required','email','string','max:255','unique:users'],
        'phone' => ['required','string','max:15','unique:users'],
        'language' => ['required','in:en,ha'],
        'password' => ['required','string','min:8','confirmed'],
    ];
     public function register()
    {
        try {
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
            app()->setLocale($this->language);
            session()->flash('message', app()->getLocale() == 'ha' ? 'An qieiri asusnka cikin nasara! ka duba imel qin kan don tabbatarwa. ' : 'Your account has created successfully! Check your email for verification.');
            return redirect()->route('verification.notict');   
        } catch (\Exception $e) {
            $this->addError('form', app()->getLocale() == 'ha' ? 'An samu mastala yayin qirqurar asusu: '.$e->getMessage() : 'An error occrred while creating your account: '.$e->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.pages.auth.register')->layout('layouts.guest');
    }
}
