<?php
namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DeliveryProofUploaded extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    /**
     * إنشاء مثيل جديد للإشعار.
     * @param Payment $payment نموذج الدفعة
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
    }

    /**
     * بناء البريد الإلكتروني.
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('delivery.proof_uploaded_subject', 'New Delivery Proof Uploaded'))
                    ->view('emails.delivery-proof-uploaded')
                    ->with(['payment' => $this->payment]);
    }
}