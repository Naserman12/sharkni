<?php

namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Rental;
use App\Services\PaystackService;
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

    public function index()
    {
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

    public function verifyPayment($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        try {
            $transaction = $this->paystackService->verifyPayment($payment->transaction_id);
            if ($transaction->status === 'success') {
                $payment->update([
                    'status' => 'confirmed',
                    'transaction_id' => $transaction->reference,
                    'payment_method' => $transaction->channel,
                ]);

                $payment->borrowRequest->update([
                    'is_paid' => true,
                    'payment_status' => 'confirmed',
                ]);

                \Mail::to($payment->tool->user->email)->queue(new \App\Mail\PaymentConfirmed($payment));

                session()->flash('message', __('Payment confirmed successfully.'));
            } else {
                $payment->update(['status' => 'failed']);
                session()->flash('error', __('Payment failed. Please try again.'));
            }
        } catch (\Exception $e) {
            Log::error('Payment verification error: ' . $e->getMessage());
            session()->flash('error', __('Failed to verify payment.'));
        }

        return redirect()->route('payments.index');
    }

    public function handleWebhook(Request $request)
    {
        $signature = $request->header('x-paystack-signature');
        $input = $request->getContent();
        $secret = config('services.paystack.secret_key');
        if ($signature !== hash_hmac('sha512', $input, $secret)) {
            Log::error('Invalid Paystack webhook signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $event = $request->input('event');
        $data = $request->input('data');

        if ($event === 'charge.success') {
            $payment = Payment::where('transaction_id', $data['reference'])->first();
            if ($payment && $payment->status !== 'confirmed') {
                $payment->update([
                    'status' => 'confirmed',
                    'payment_method' => $data['channel'],
                ]);

                $payment->borrowRequest->update([
                    'is_paid' => true,
                    'payment_status' => 'confirmed',
                ]);

                \Mail::to($payment->tool->user->email)->queue(new \App\Mail\PaymentConfirmed($payment));
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
