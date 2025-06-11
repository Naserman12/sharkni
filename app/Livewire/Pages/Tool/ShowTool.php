<?php

namespace App\Livewire\Pages\Tool;

use App\Models\Comment;
use App\Models\Rental;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use App\Notifications\rentalNotification;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTool extends Component
{
    use WithPagination;
    public $tool, $borrow_date, $return_date;
    public $newComment;
    protected $rules =[
        'newComment' => 'required|string|min:3|max:255',
    ];
    public function mount($id){
        $this->tool = Tool::with(['user', 'category','comments.user'])->findOrFail($id);
        $this->borrow_date = now()->toDateString();
        $this->return_date = now()->addDays(1)->toDateString();
         $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
    }
  
    public function addComment(){
        $this->validate();
        Comment::create([
            'tool_id' => $this->tool->id,
            'user_id' => Auth::id(),
            'content' => $this->newComment,
        ]);
        $this->tool = Tool::with('user', 'category', 'comments.user')->findOrFail($this->tool->id);
        session()->flash('message', app()->getLocale() == 'ha' ? 'An qara sharhi cikin nasara!' : 'Comment added successfully!');
        $this->reset(['newComment']);
    }
    public function rental($toolId){
        $tool = Tool::findOrFail($toolId);
        $this->validate([
            'borrow_date' => 'required|date|after_or_equal:today',
            'return_date' => 'required|date|after:borrow_date',
        ]);
        $days = Carbon::parse($this->borrow_date)->diffInDays($this->return_date);
        $deposit_amount = $this->tool->deposit_amount;
        $total_cost = $this->tool->deposit_amount + $this->tool->rental_price * $days;

        $rental = Rental::create([
            'tool_id' => $this->tool->id,
            'borrower_id' => Auth::id(),
            'lender_id' => $this->tool->user_id,
            'status' => 'pending',
            'borrow_date' => $this->borrow_date,
            'deposit_amount' => $deposit_amount,
            'return_date' => $this->return_date,
            'is_paid' => $this->tool->is_free,
            'total_cost' => $total_cost,
            'deposit_status' => 'pending',
        ]);
        $toolOwner = $tool->user;
        $toolOwner->notify(new rentalNotification($rental));
        session()->flash('message', app()->getLocale() == 'ha' ? 'An aika da neman aro zowa ga mai kaia.' : 'Rental request sent successfully.');
                // إعادة توجيه إلى صفحة الدفع مع معرف الإجارة
         return redirect()->route('payment.form', [ 'rentalId'=>$rental->id, 'toolId' => $toolId]);

    }
     public function deleteTool($id)
    {
        $tool = Tool::findOrFail($id);
        if ($tool->user_id !== Auth::id()) {
            abort(403, app()->getLocale() == 'ha' ? 'Ba za ka iya share wannan kayan aiki ba!' : 'You are not authorized to delete this tool!');
        }

        $tool->delete();
        session()->flash('success', app()->getLocale() == 'ha' ? 'An share kayan aiki cikin nasara!' : 'Tool deleted successfully!');
        return redirect()->route('tools.index');
    }
    public function render()
    {
        return view('livewire.pages.tool.show-tool')->layout('layouts.app');
    }
}
