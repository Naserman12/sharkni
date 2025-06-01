<?php 
namespace App\Services;

use Illuminate\Support\Facades\Log;
use Unicodeveloper\Paystack\Paystack;

class PaystackService{
    protected $paystack;

    public function __construct(){
        $this->paystack = new Paystack();
    }
    public function initiatePayment($paymentId, float $amount, $email, string $callbackUrl){
        $data = [
            'amount' => $amount,
            'email' => $email,
            'callbackUrl'=> $callbackUrl,
            'metadata' => [
               'payment_id' => $paymentId,
            ],
        ];
        try {
            $response = $this->paystack->transaction->initialiaze($data);
            return $response->data->authorization_url;
        } catch (\Exception $e) {
            Log::error('Paystack Payment Initiation Failed: ' .$e->getMessage());
            throw new \Exception(__('Failed to initiate payment.'));
        }
    }
    public function verfyPayment($reference){
        try {
            $response = $this->paystack->transaction->verify(['reference' => $reference]);
            return $response->data;
        } catch (\Exception $e) {
            Log::error('Payment Verification Failed: ' .$e->getMessage());
            throw new \Exception(__('Failed to verify payment.'));
        }
    }
}