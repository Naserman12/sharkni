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
        try {
            $reference = Paystack::genTranxRef();
            // إنشاء سجل معاملة
            PaystackTransaction::create([
                'payment_id' => $payment->id,
                'reference' => $reference,
                'email' => $email
            ]);
       
             // إعداد بيانات الدفع
        $data = [
            'amount' => (int) (floatval($payment->amount) * 100), // تحويل المبلغ إلى كوبو
            'email' => $email,
            'currency' => 'NGN',
            'reference' => $reference,
            'callback_url' => route('paystack.callback'),
            'metadata' => [
                'payment_id' => $payment->id,
                'tool_id' => $payment->tool_id,
                'rental_id' => $payment->rental_id,
                'user_id' => $payment->user_id,
            ],
            'quantity' => 1, // إضافة الكمية
        ];
            session()->put('paystack_payment', $data);
            // طلب رابط التفويض باستخدام $data مباشرة
            $url = Paystack::getAuthorizationUrl($data)->url;
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
                // التحقق من المرجع
            if (empty($reference) || !is_string($reference)) {
                Log::error('Invalid Reference', ['reference' => $reference]);
                return [
                    'status' => false,
                    'message' => 'Invalid or missing reference'
                ];
            }
              // التأكد من أن المرجع مخزن في الجلسة
            $sessionData = session('paystack_payment');
            if (!isset($sessionData['reference']) || $sessionData['reference'] !== $reference) {
                Log::warning('Reference mismatch or missing in session', ['session' => $sessionData, 'provided_reference' => $reference]);
                $sessionData['reference'] = $reference;
                session()->put('paystack_payment', $sessionData);
            }
             $paystack = new \Unicodeveloper\Paystack\Paystack();
              // التحقق من صحة المعاملة باستخدام isTransactionVerificationValid
            if (!$paystack->isTransactionVerificationValid($reference)) {
                Log::error('Transaction verification failed', ['reference' => $reference]);
                return [
                    'status' => false,
                    'message' => 'Payment verification failed: Invalid transaction reference'
                ];
            }
            $paymentDetails = $paystack->getPaymentData();
            $paymentDetails = json_decode(json_encode($paymentDetails), true); // تحويل إلى مصفوفة
            // التحقق من الاستجابة
            if (!isset($paymentDetails['data']) || !is_array($paymentDetails['data'])) {
                return[
                    'status' => false,
                    'message' => 'Payment verification failed: Invalid response structure',
                ];
            }
            $data = $paymentDetails['data'];
             // التحقق من وجود مفتاح reference
            if (!isset($data['reference']) || $data['reference'] !== $reference) {
                Log::error('Reference key missing or mismatch in Paystack response', ['data' => $data, 'provided_reference' => $reference]);
                return [
                    'status' => false,
                    'message' => 'Payment verification failed: Reference not found or mismatch'
                ];
            }
            if($data['status'] !== 'success'){
                return[
                    'status' => false,
                    'message' => 'Payment not successful!',
                ];        
            }
            return [
                'status' => true,
                'payment_status' => $data['status'],
                'amount' => $data['amount'] / 100,
                'reference' => $data['reference'],
                'transaction_id' => $data['id'],
                "currency" => $data['currency'],
                'paid_at' => $data['paid_at'],
                'customer' => $data['customer'],
                'metadata' => $data['metadata'],
            ];
        } catch (\Exception $e) {
            dd('سبب الخطـأ \' ' .$e->getMessage());
            Log::error('Payment Verification Failed: ' .$e->getMessage());
            return [
                'status' => false,
                'message' => 'Error Verifing payment',
                'error' => $e->getMessage()
            ];
        }
    }
    public function handCallback(string $reference){
        $paymentDetails = $this->verifyPayment($reference);
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
        $payment->paystackTransaction()->update([
            'transaction_id'  => $paymentDetails['transaction_id'],
            'metadata'        => $paymentDetails['metadata'],
            'customer'        => $paymentDetails['customer'],
            'paid_at'         => $paymentDetails['paid_at'],
            'gateway_response'=> json_encode($paymentDetails),
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
