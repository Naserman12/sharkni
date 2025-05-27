<?php

namespace App\Livewire\Pages\Tool;

use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowTool extends Component
{
    public $tool;
    public function mount($id){
        $this->tool = Tool::with(['user', 'category'])->findOrFail($id);
         $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
    }
    public function render()
    {
        return view('livewire.pages.tool.show-tool')->layout('layouts.app');
    }
}
