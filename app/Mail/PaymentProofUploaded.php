<?php
namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentProofUploaded extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    public function build()
    {
        return $this->subject(__('New Payment Proof Uploaded'))
                    ->view('emails.payment-proof-uploaded')
                    ->with([
                        'payment' => $this->payment,
                        'rental'=> $this->payment->rental,
                        'tool'=> $this->payment->tool,
                    ]);
    }
}