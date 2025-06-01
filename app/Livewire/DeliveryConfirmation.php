<?php
namespace App\Http\Livewire;

use App\Models\Payment;
use Livewire\Component;
use Livewire\WithFileUploads;


class DeliveryConfirmation extends Component
{
    use WithFileUploads;

    public $paymentId;
    public $deliveryCode;
    public $proofOfDelivery;

    protected $rules = [
        'deliveryCode' => 'required|string|size:6',
        'proofOfDelivery' => 'nullable|image|max:2048',
    ];

    public function mount($paymentId)
    {
        $this->paymentId = $paymentId;
    }

    public function confirmDelivery()
    {
        $this->validate();

        $payment = Payment::findOrFail($this->paymentId);

        if ($payment->delivery_code === $this->deliveryCode) {
            $payment->update([
                'is_delivered' => true,
                'status' => 'delivered',
            ]);

            $payment->borrowRequest->update(['payment_status' => 'delivered']);

            \Mail::to($payment->user->email)->queue(new \App\Mail\DeliveryConfirmed($payment));
            \Mail::to($payment->tool->user->email)->queue(new \App\Mail\DeliveryConfirmed($payment));

            session()->flash('message', __('Delivery confirmed successfully.'));
        } else {
            session()->flash('error', __('Invalid delivery code.'));
        }

        if ($this->proofOfDelivery) {
            $path = $this->proofOfDelivery->store('delivery_proofs', 'public');
            $payment->update(['proof_of_delivery' => $path]);
            \Mail::to('admin@shaarikii.com')->queue(new \App\Mail\DeliveryProofUploaded($payment));
        }

        return redirect()->route('payments.index');
    }

    public function render()
    {
        return view('livewire.delivery-confirmation');
    }
}