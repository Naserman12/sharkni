<?php

namespace App\Livewire\Pages\Rentals;

use Livewire\Component;
use App\Models\Rental;

class CompleteRental extends Component
{
    public $rentalId;
    public $rental;
    public $payment ,$paymentMethod, $paymentType;

    public function mount($id)
    {
        $this->rentalId = $id;
        $this->rental = Rental::with('tool', 'borrower', 'payment')->findOrFail($id);
        $this->paymentMethod = $this->rental->payment->payment_method ?? 'none';
        $this->paymentType = $this->rental->payment->status ??'none';
        // dd($this->paymentMethod, 'Type ='.$this->paymentType);
    }

    public function acceptRequest()
    {
        $this->rental->update([
            'status' => 'approved',
            'paymeny_status' => $this->paymentType,
        ]);

        session()->flash('success', __('messages.request_accepted'));

        return redirect()->route('rentals.index');
    }

    public function rejectRequest()
    {
        $this->rental->update([
            'status' => 'cancelled',
        ]);

        session()->flash('success', __('messages.request_rejected'));

        return redirect()->route('rentals.index');
    }

    public function completeRequest()
    {
        // $this->validate();

        $this->rental->update([
            'status' => 'comfirmed',
            'paymeny_status' => $this->paymentType,
        ]);

        session()->flash('success', __('messages.request_completed'));

        return redirect()->route('rentals.index');
    }

    public function render()
    {
        return view('livewire.pages.rentals.complete-rental')->layout('layouts.app');
    }
}