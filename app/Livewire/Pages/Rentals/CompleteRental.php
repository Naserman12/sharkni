<?php

namespace App\Livewire\Pages\Rentals;

use Livewire\Component;
use App\Models\Rental;

class CompleteRental extends Component
{
    public $rentalId;
    public $rental;
    public $paymentStatus = 'none';

    protected $rules = [
        'paymentStatus' => 'required|in:pending,awaiting_comfirmation,comfirmed',
    ];

    public function mount($id)
    {
        $this->rentalId = $id;
        $this->rental = Rental::with('tool', 'borrower')->findOrFail($id);
        $this->paymentStatus = $this->rental->payment_status ?? 'none';
    }

    public function acceptRequest()
    {
        $this->validate();

        $this->rental->update([
            'status' => 'approved',
            'payment_status' => $this->paymentStatus,
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
        $this->validate();

        $this->rental->update([
            'status' => 'comfirmed',
            'payment_status' => $this->paymentStatus,
        ]);

        session()->flash('success', __('messages.request_completed'));

        return redirect()->route('rentals.index');
    }

    public function render()
    {
        return view('livewire.pages.rentals.complete-rental')->layout('layouts.app');
    }
}