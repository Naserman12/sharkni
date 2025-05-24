<?php 
namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email, $password;

    public function login()
    {
        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->flash('message', 'Login Successfully');
            return redirect()->route('dashboard');
        }
        session()->flash('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
