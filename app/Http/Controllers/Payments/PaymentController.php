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
        $payments = Payment::where('user_id', Auth::id())->orWhere('user_id',Auth::user()->email === 'admin@gmail.com')->get();
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
 public function handlePaystackCallback(Request $request, PaystackService $paystackService)
{
    $reference = $request->query('trxref') ?? $request->query('reference');
    // dd($reference);
    if (!$reference) {
        session()->flash('error', 'Reference not found');
        return redirect()->route('payment.failure');
    }
    $result = $paystackService->handCallback($reference);
    // dd($result['status']);
    if ($result['status']) {
        session()->put('success', 'تم الدفع بنجاح');
         session()->put('payment_id', $result['payment']->id);
    
        return redirect()->route('payment.success', ['reference' => $reference]); // إعادة توجيه إلى paymentSuccess
    }
    session()->flash('error', $result['message']);
    return redirect()->route('payment.failure');
}

 public function paymentSuccess(Request $request)
{
    try {
        Log::info('Accessing Payment Success Page', [
            'session' => session()->all(),
            'request' => $request->all(),
            'reference' => $request->query('reference')
        ]);
        if (!session()->has('success')) {
            Log::warning('Access to payment success page without success session', ['request' => $request->all()]);
            $reference = $request->query('reference') ?? $request->query('trxref');
            if ($reference) {
                Log::info('Attempting to retrieve payment with reference', ['reference' => $reference]);
                // التحقق من العلاقة  (paystackTransaction)
                $payment = Payment::whereHas('paystackTransaction', function ($query) use ($reference) {
                    $query->where('reference', $reference);
                })->first();
                if ($payment) {
                    Log::info('Payment found', ['payment_id' => $payment->id, 'status' => $payment->status]);
                    if ($payment->status === Payment::STATUS_CONFIRMED) {
                        Log::info('Payment retrieved from database', ['payment' => $payment->toArray()]);
                        return view('payments.success', ['payment' => $payment]);
                    } else {
                        Log::warning('Payment not confirmed', ['payment_id' => $payment->id, 'status' => $payment->status]);
                    }
                } else {
                    Log::warning('No payment found for reference', ['reference' => $reference]);
                }
            } else {
                Log::warning('No reference provided in request');
            }
            return redirect()->route('tools.index')->with('error', 'لا يمكن الوصول إلى صفحة النجاح بدون دفع ناجح');
        }
        $payment = Payment::find(session('payment_id'));
        Log::info('Payment retrieved from session', ['payment_id' => session('payment_id'), 'payment' => is_object($payment) ? $payment->toArray() : $payment]);
        if (!$payment) {
            Log::warning('Payment data missing in session', ['reference' => $request->query('reference')]);
            return redirect()->route('tools.index')->with('error', 'بيانات الدفع غير متوفرة');
        }
        session()->forget(['success', 'payment', 'paystack_payment']);
        Log::info('Session cleared after payment success');

        return view('payments.success', ['payment' => $payment]);
    } catch (\Exception $e) {
        dd( 'message =>' . $e->getMessage());
      
        return redirect()->route('tools.index')->with('error', 'حدث خطأ أثناء معالجة الدفع. حاول مرة أخرى لاحقًا.');
    }
}
    public function paymentfailed(){
        return view('payments.failed',[
            'error' => session('error')
        ]);
    }
    public function paymentFailure(Request $request)
{
    try {
        Log::info('Accessing Payment Failure Page', [
            'session' => session()->all(),
            'request' => $request->all(),
            'reference' => $request->query('reference')
        ]);

        // استرجاع رسالة الخطأ من الجلسة إن وجدت
        $errorMessage = session('error', 'فشل عملية الدفع. يرجى المحاولة مرة أخرى أو التواصل مع الدعم.');
        $reference = $request->query('reference') ?? $request->query('trxref');

        // اختياري: استرجاع تفاصيل الدفع من قاعدة البيانات لعرضها
        $payment = null;
        if ($reference) {
            $payment = Payment::whereHas('paystackTrans', function ($query) use ($reference) {
                $query->where('reference', $reference);
            })->first();
        }

        // تسجيل إذا لم يُوجد سجل دفع
        if (!$payment) {
            Log::warning('No payment found for reference on failure page', ['reference' => $reference]);
        }

        // عرض صفحة الفشل مع البيانات
        return view('payments.failure', [
            'errorMessage' => $errorMessage,
            'reference' => $reference,
            'payment' => $payment
        ]);
    } catch (\Exception $e) {
        Log::error('Error in paymentFailure', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'reference' => $request->query('reference')
        ]);
        return redirect()->route('tools.index')->with('error', 'حدث خطأ أثناء معالجة صفحة الفشل. حاول مرة أخرى لاحقًا.');
    }
}
      public function redirectToGateway($paymentId)
    {
        try{
            $payment = Payment::find($paymentId); // 🔍 جلب السجل من قاعدة البيانات
            if (!$payment) {
                return redirect()->back()->with('error', 'الدفع غير موجود');
            }
             $result = $this->paystackService->initiatePayment($payment, Auth::user()->email);
            // dd($result);
            if ($result['status']) {
                return redirect()->away($result['authorization_url']);
            }
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
