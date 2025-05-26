<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

class VerifyEmail extends Component
{

    public function render()
    {
        try {
            Auth::user()->sendEmailVerificationNotification();
            session()->flash('message', app()->getLocale() == 'ha' ? 'An saka aiko da imel na tabbatarwa.' : 'Verification Email resnt.');
        } catch (\Exception $e) {
            session()->flash('error', app()->getLocale() == 'ha' ? 'An samu mastala yayin aiko da imel' . $e->getMessage() : 'An error occurred while resendting the email: '.$e->getMessage());
        }
        return view('livewire.pages.auth.verify-email')->layout('layouts.guest');
    }
}
