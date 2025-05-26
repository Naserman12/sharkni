<?php

namespace App\Livewire\Email;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;

class SendEmailTest extends Component
{
    public $email ;
    public $message;
    public  function send(){
        $this->validate([
            'email' => 'required|email',
            'message' => 'required|string',
        ]);
        try {
            //code...
            Mail::raw($this->message, function($email){
                $email->to($this->email)->subject('رسالة من النظام');
        });
        session()->flash('message', 'تم إرسال البدريد');
        $this->reset(['email', 'message']);
        } catch (\Exception $e) {
            session()->flash('error', 'Error Mess' .$e->getMessage());
        }
     return redirect()->back()->with('error');
    }
    public function render()
    {
        return view('livewire.email.send-email-test');
    }
}
