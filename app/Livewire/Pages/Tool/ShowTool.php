<?php

namespace App\Livewire\Pages\Tool;

use App\Models\Rental;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTool extends Component
{
    use WithPagination;
    public $tool, $borrow_date, $return_date;
    public function mount($id){
        $this->tool = Tool::with(['user', 'category'])->findOrFail($id);
        $this->borrow_date = now()->toDateString();
        $this->return_date = now()->addDays(1)->toDateString();
         $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
    }
    public function requestBorrow(){
        $this->validate([
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
        ]);
        $days = Carbon::parse($this->borrow_date)->diffInDays($this->return_date);
        $total_cost = $this->tool->is_free ? 0 : $this->tool->price * $days;

        Rental::create([
            'tool_id' => $this->tool->id,
            'borrower_id' => Auth::id(),
            'lender_id' => $this->tool->user_id,
            'status' => 'pending',
            'borrow_date' => $this->borrow_date,
            'return_date' => $this->return_date,
            'is_paid' => $this->tool->is_free,
            'total_cost' => $total_cost,
            'deposit_status' => 'paid',
        ]);
        session()->flash('message', app()->getLocale() == 'ha' ? 'An aika da neman aro zowa ga mai kaia.' : 'Rental request sent successfully.');

        return redirect()->to('rentals');

    }
    public function render()
    {
        return view('livewire.pages.tool.show-tool')->layout('layouts.app');
    }
}
