<?php 
namespace App\Livewire\Pages\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email, $password, $remember = false;

    protected $rules =[
        'email' => ['required', 'email'],
        'password' => ['required'],
    ];
    public function login()
    {
        try {
            $this->validate();
            if (Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
                $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
                session()->flash('message', app()->getLocale() == 'ha' ? 'Ka shiga cikin nasara!' : 'You have login in successfully!');
                return redirect()->intended(route('dashboard'));
            }
            $this->addError('email', app()->getLocale() == 'ha' ? 'Imel Ko kalmar sirri ba daidai ba ne.': 'Invalid email or password');
        } catch (\Exception $e) {
            // \Log::error('Login error', app()->getLocale() == 'ha' ? 'Imel  ko kalmar sirri ba daidai ba ne. ' : 'Invalid email or password');
            $this->addError('form', app()->getLocale() == 'ha' ? 'An samu masala yayin sgiga: '.$e->getMessage() : 'An error occured while logging in:'.$e->getMessage());
        }
        // session()->flash('error', 'البريد الإلكتروني أو كلمة المرور غير صحيحة');
    }
    public function render()
    {
        return view('livewire.pages.auth.login')->layout('layouts.guest');
    }
}
