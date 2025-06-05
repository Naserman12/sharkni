<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use App\Services\PaystackService;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
      protected $paystackService;

      public function __construct(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }
    public function initiatePayment(Request $request){
        $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'email' => 'required|email',
        ]);
    try {
        $payment = Payment::findOrFail($request->payment_id);
        $result = $this->paystackService->initiatePayment($payment, $request->email);

        if (!$result['status']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'error' => $result['error'] ?? null
            ],400);
        }
        return response()->json([
            'success' => true,
            'authorization' => $result['authorization_url'],
            'reference' => $result['reference']
        ]);
    } catch (\Exception $e) {
        Log::error('paystack Intiation Controller Error'.$e->getMessage());
       
            return response()->json([
                'success' => false,
                'message' => 'Faild to initiate payment',
                'error' => $e->getMessage()
            ],500);

    }
    }

    public function index()
    {
         // استعراض المدفوعات الخاصة بالمستخدم الحالي
        $payments = Payment::where('user_id', Auth::id())->get();
        return view('payments.index', compact('payments'));
    }
       public function showPaymentForm(Rental $rental)
    {
        // التأكد من أن المستخدم هو صاحب الطلب
        if ($rental->borrower_id !== Auth::id()) {
            abort(403, __('Unauthorized access.'));
        }

        // التحقق من أن الطلب لم يُدفع بعد
        if ($rental->is_paid) {
            return redirect()->route('payments.index')->with('error', __('This request has already been paid.'));
        }

        return view('payments.form', compact('rental'));
    }

    public function verifyPayment(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);
       try {
           $result = $this->paystackService->verifyPayment($request->reference);
            if (!$result['status']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'error' => $result['error']
            ],400);
            }
            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Faild to verify payment',
                'error' => $e->getMessage()
            ],500);
        }
    }
    public function callback(Request $request){
        try {
            if (!$request->has('reference')) {
                return redirect()->route('payment.failed')->with('error', 'Payment Id not found');
            }
            $callbackResult  = $this->paystackService->handCallback();
            if (!$callbackResult['status']) {
                return redirect()->route('payment.failed')->with('error', $callbackResult['message']);
            }
            return redirect()->route('payment.success')->with([
                'success' => 'Payment has successfully',
                'payment' => $callbackResult['payment']
            ]);
        } catch (\Exception $e) {
            return redirect()->route('payment.failed')->with('error', 'Payment has Failed');
        }
    }
    public function redirectToPayment(Payment $payment){
        return view('payments.paystack',[
            'payment' => $payment,
            'paystackTransaction' => $payment->paystackTransaction,
        ]);
    }
    public function paymentSuccess(){
        if (!session()->has('success')) {
           return redirect()->route('tools.index');
        }
        return view('payments.success', [
            'payment' => session('payment')
        ]);
    }
    public function paymentfailed(){
        return view('payments.failed',[
            'error' => session('error')
        ]);
    }
      public function redirectToGateway($paymentId)
    {
        try{
            $payment = Payment::find($paymentId); // 🔍 جلب السجل من قاعدة البيانات
            if (!$payment) {
                return redirect()->back()->with('error', 'الدفع غير موجود');
            }
            $email = Auth::user()->email;
        return $this->paystackService->initiatePayment($payment, $email);
        }catch(\Exception $e) {
            return redirect()->back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }


       public function handleWebhook(Request $request)
    {
        // التحقق من التوقيع للتأكد من أن البيانات جاءت من Paystack
        $signature = $request->header('x-paystack-signature');
        $input = $request->getContent();
        $secret = config('services.paystack.secret_key');
        
        // التحقق من صحة التوقيع
        if ($signature !== hash_hmac('sha512', $input, $secret)) {
            Log::error('Invalid Paystack webhook signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // الحصول على الحدث وبيانات المعاملة
        $event = $request->input('event');
        $data = $request->input('data');

        // التعامل مع الحدث عند نجاح الدفع
        if ($event === 'charge.success') {
            $payment = Payment::where('transaction_id', $data['reference'])->first();
            if ($payment && $payment->status !== 'confirmed') {
                $payment->update([
                    'status' => 'confirmed',
                    'payment_method' => $data['channel'],
                ]);

                // تحديث حالة الإيجار على أنه تم الدفع
                $payment->rental->update([
                    'is_paid' => true,
                    'payment_status' => 'confirmed',
                ]);

                // إرسال بريد إلكتروني لتأكيد الدفع
                \Mail::to($payment->rental->user->email)->queue(new PaymentConfirmed($payment));
            }
        }

        // إرجاع استجابة بأن البيانات تم استلامها بنجاح
        return response()->route('payment.success', ['payment' => $payment->id]);
    }
}
