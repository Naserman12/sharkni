<?php

namespace App\Livewire\Pages\Rentals;

use App\Models\Rental;
use App\Models\Tool;
use App\Notifications\rentalNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RentalRequests extends Component
{
    public $rentals;
    
    public function mount(){
        // استرجاع الطلبات 
        $this->rentals =Rental::where('borrower_id', Auth::id())
        ->orWhere('lender_id',Auth::id())
        ->with(['tool', 'borrower', 'lender'])
        ->get();

        
    }
    // public function requestBorrow($toolId){
    //     $tool = Tool::findOrFail($toolId);
        
    //     $rental = Rental::create([
    //         'user_id' => Auth::id(),
    //         'tool_id' => $toolId,
    //         'status' => 'pending',
    //         'total_cost' => $tool->rental_price +  $tool->deposit_amount,
    //     ]);
    //     $toolOwner = $tool->user;
    //     $toolOwner->notify(new rentalNotification($rental));
    //     session()->flash('message', app()->getLocale() == 'ha' ? 'An qaddamar da neman aro cikin nasara!.' : 'Borrow request submit successfully!');
    // } 
    public function approve($rentalId){
        $rental = Rental::findOrFail($rentalId);
        if ($rental->lender_id === Auth::id()&& $rental->status === 'pending' ) {
           $rental->status = 'approved';
           $rental->save();

           $rental->tool->status ='borrowed';
           $rental->tool->save();

           session()->flash('message', app()->getLocale() == 'ha' ? 'An amince da neman aro.' : 'Rental request approved.');
        }
        $this->mount(); // إعادة تحميل الطلبات
    }
    public function cancel($rentalId){
        $rental = Rental::findOrFail($rentalId);
        $rental->status = 'cancelled';
        $rental->save();

        session()->flash('message', app()->getLocale() == 'ha' ? 'An soke neman aro': 'Rental request cancelled.');
        $this->mount();
    }
    public function render()
    {
        return view('livewire.pages.rentals.rental-requests')->layout('layouts.app');
    }
}
