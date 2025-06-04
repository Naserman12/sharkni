<?php 
// namespace App\Services;

// use App\Models\payment;
// use App\Models\PaystackTransaction;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Log;
// use Unicodeveloper\Paystack\Paystack;
// // use GuzzleHttp\Client;

// class PaystackService{
//     protected $paystack;
//     public function __construct(){
//         $this->paystack = new Paystack();
//         // dd($this->paystack);

//     }
    
//         public function initiatePayment(Payment $payment, string $email){
            
//             try {
//                 $reference = $this->paystack->genTranxRef();
//                 // إنشاء سجل معاملة
//                 PaystackTransaction::create([
//                     'payment_id' => $payment->id,
//                     'reference' => $reference,
//                     'email' => $email
//                 ]);

//                 //  تحضير بيانات الدفع
//                 $data = [
//                     'amount' => $payment->amount * 100,
//                     'email' => $email,
//                     'reference' => $reference,
//                     'metadata' =>[
//                         'payment_id' => $payment->id,
//                         'tool_id' => $payment->tool_id,
//                         'rental_id' => $payment->rental_id,
//                         'user_id' => $payment->user_id,
//                     ],
//                 'callback_url' => route('payment.callback')
//                 ];
//                 // الحصول على رابط الدفع
//                 $authorizationUrl = $this->paystack->getAuthorizationUrl($data);
//                 return [
//                     'status' => true,
//                     'authorization_url' => $authorizationUrl->url,
//                     'reference' => $reference,
//                 ];

//             } catch (\Exception $e) {
//                 Log::error('Paystack Payment Initiation Failed: ' .$e->getMessage());
//                 return [
//                     'status' => false,
//                     'message' => 'Paystack Payment Initiation Failed',
//                     'error' => $e->getMessage()
//                 ];
//             }
//         }
//         public function verifyPayment(string $reference){
//             try {
//                 $paymentDetails = $this->paystack->getPaymentData();

//                 if (!$paymentDetails['status']) {
//                     return[
//                         'status' => false,
//                         'message' => 'Payment verification failed'
//                     ];
//                 }
//                 $data = $paymentDetails['data'];

//                 return [
//                     'status' => true,
//                     'payment_status' => $data['status'],
//                     'amount' => $data['amount'] /100,
//                     'reference' => $data['reference'],
//                     'transaction_id' => $data['id'],
//                     'paid_at' => $data['paid_at'],
//                     'customer' => $data['customer'],
//                     'metadata' => $data['metadata'],
//                 ];
//             } catch (\Exception $e) {
//                 Log::error('Payment Verification Failed: ' .$e->getMessage());
//                  return [
//                     'status' => false,
//                     'message' => 'Error Verifing patment',
//                     'error' => $e->getMessage()
//                 ];
//             }
//         }  
//         public function handCallback(){
//             $paymentDatails = $this->verifyPayment(request()->reference);
//             if (!$paymentDatails['status']) {
//                 return $paymentDatails;
//             }
//             $payment = Payment::whereHas('paystackTransaction', function($query) use ($paymentDatails) {
//                 $query->where('reference', $paymentDatails['reference']);
//             })->first();
//             if (!$payment) {
//                 return [
//                     'status' => false,
//                     'message' => 'Payment record not found'
//                 ];
//             }
//             $payment->paystackTrans()->update([
//                 'transaction_id' => $paymentDatails['transaction_id'],
//                 'metadat'=> $paymentDatails['metadata'],
//                 'customer'=> $paymentDatails['customer'],
//                 'paid_at' => $paymentDatails['paid_at'],
//                 'gateway_response' => json_encode($paymentDatails),
//             ]);
//             return [
//                 'status' => true,
//                 'payment' => $payment,
//                 'message' => 'payment processed successfully',
//             ];
//         }  
// }