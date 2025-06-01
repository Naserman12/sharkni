<?php
namespace App\Http\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;

class AdminPaymentConfirmation extends Component
{
    public $payments;

    public function mount()
    {
        $this->payments = Payment::where('status', 'awaiting_confirmation')->get();
    }

    public function confirmPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update([
            'status' => 'confirmed',
        ]);

        $payment->borrowRequest->update([
            'is_paid' => true,
            'payment_status' => 'confirmed',
        ]);

        \Mail::to($payment->user->email)->queue(new \App\Mail\PaymentConfirmed($payment));
        \Mail::to($payment->tool->user->email)->queue(new \App\Mail\PaymentConfirmed($payment));

        session()->flash('message', __('Payment confirmed successfully.'));
        $this->mount();
    }

    public function rejectPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);
        $payment->update([
            'status' => 'failed',
        ]);

        $payment->borrowRequest->update([
            'payment_status' => 'failed',
        ]);

        \Mail::to($payment->user->email)->queue(new \App\Mail\PaymentRejected($payment));

        session()->flash('message', __('Payment rejected.'));
        $this->mount();
    }

    public function render()
    {
        return view('livewire.admin.admin-payment-confirmation');
    }
}