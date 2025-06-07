<?php 
namespace App\Services;

use App\Models\Payment;
use App\Models\PaystackTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaystackService {

    public  $payment, $email;

    public function mount(Payment $payment){
        $this->payment = $payment;
        $this->email = Auth::user()->email;
    }
    public function initiatePayment(Payment $payment, string $email){
        // dd($payment->amount * 100);
        // dd(config('app.url') . '/payments/callback?payment_id=' . $payment->id,);
        try {
            $reference = Paystack::genTranxRef();
            // إنشاء سجل معاملة
            PaystackTransaction::create([
                'payment_id' => $payment->id,
                'reference' => $reference,
                'email' => $email
            ]);
            
            session()->put('paystack_payment', [
            'amount' => (int) $payment->amount,
            'email' => $email,
            'reference' => $reference,
            'callback_url' => url('/payments/callback?payment_id=' . $payment->id),
            'metadata' => [
                'payment_id' => $payment->id,
                'tool_id' => $payment->tool_id,
                'rental_id' => $payment->rental_id,
                'user_id' => $payment->user_id,
            ],
            ]);
            // dd(session('paystack_payment'));

            // ✅ ثم طلب رابط التفويض
            // dd('Url = ', Paystack::getAuthorizationUrl()->url);
            $url = Paystack::getAuthorizationUrl()->url;
            //  dd($url);
            return [
                'status' => true,
                'authorization_url' => $url,
            ];
        } catch (\Exception $e) {
                dd('سبب الخطـأ \' ' .$e->getMessage());
            Log::error('Paystack Payment Initiation Failed: ' .$e->getMessage());
            return [
                'status' => false,
                'message' => 'Paystack Payment Initiation Failed',
                'error' => $e->getMessage()
            ];
        }
        
    }

    public function verifyPayment(string $reference){
        try {
            $paymentDetails = Paystack::getPaymentData($reference);

            if (!$paymentDetails['status']) {
                return[
                    'status' => false,
                    'message' => 'Payment verification failed'
                ];
            }

            $data = $paymentDetails['data'];

            return [
                'status' => true,
                'payment_status' => $data['status'],
                'amount' => $data['amount'] / 100,
                'reference' => $data['reference'],
                'transaction_id' => $data['id'],
                'paid_at' => $data['paid_at'],
                'customer' => $data['customer'],
                'metadata' => $data['metadata'],
            ];
        } catch (\Exception $e) {
            Log::error('Payment Verification Failed: ' .$e->getMessage());
            return [
                'status' => false,
                'message' => 'Error Verifing payment',
                'error' => $e->getMessage()
            ];
        }
    }

    public function handCallback(){
        $paymentDetails = $this->verifyPayment(request()->reference);

        if (!$paymentDetails['status']) {
            return $paymentDetails;
        }

        $payment = Payment::whereHas('paystackTransaction', function($query) use ($paymentDetails) {
            $query->where('reference', $paymentDetails['reference']);
        })->first();

        if (!$payment) {
            return [
                'status' => false,
                'message' => 'Payment record not found'
            ];
        }
        $payment->paystackTrans()->update([
            'transaction_id' => $paymentDetails['transaction_id'],
            'metadata'=> $paymentDetails['metadata'],
            'customer'=> $paymentDetails['customer'],
            'paid_at' => $paymentDetails['paid_at'],
            'gateway_response' => json_encode($paymentDetails),
        ]);

        $payment->update([
        'status' => Payment::STATUS_CONFIRMED
         ]);

        return [
            'status' => true,
            'payment' => $payment,
            'message' => 'Payment processed successfully',
        ];
    }
}
