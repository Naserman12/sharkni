<?php

namespace App\Livewire;

use App\Models\Setting;
use App\Models\Rental;
use App\Models\payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Services\PaystackService;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;

class OrPaymentForm extends Component
{
    use WithFileUploads;
    public  $rentalId, 
            $paymentType = 'paystack', 
            $payment_method,
            $proofOfPayment, 
            $amount, 
            $depositAmount,
            $rentalAmount,
            $processingFee,
            $virtualAccountDetails,
            $paystackService;

            protected $rules =[
                'paymentType' => 'required|in:paystack,virtual_account',
                'proofOfPayment' => 'required_if:paymentType,virtual_account|image|max:2048',
            ];
    public function mount($rentalId, PaystackService $paystackService){
        // تحميل طلب الإجار
        $rental = Rental::with('tool')->findOrFail($rentalId);
        $this->rentalId = $rentalId;
        $this->rentalAmount = $rental->tool->rental_price ?? 0;
        // $this->depositAmount = $this->rentalAmount * 0.02;
        $this->amount = $this->rentalAmount  + $this->depositAmount ;
        $this->processingFee = $this->paymentType === 'paystack' ? $rental->total_cost * 0.022 : min($rental->otal_cost * 0.01, 300);
        $this->amount += $this->processingFee;

        // جلب تفاصيل الأفتراضي من الإعدادت
        $this->virtualAccountDetails = Setting::where('name', 'virtual_account')->first();
        $this->virtualAccountDetails= $this->virtualAccountDetails->value ?? [];
    }
    public function updatePatmentType(){
        // $this->processingFee = $this->paymentType === 'paystack'? $this->rentalAmount * 0.0015 :  min($this->amount * 0.01, 300);
        // $this->amount = $this->rentalAmount + $this->depositAmount + $this->processingFee;
        $this->calculateAmount();
    }
       protected function calculateAmount()
    {
        $this->amount = $this->rentalAmount + $this->depositAmount;
        $this->processingFee = $this->paymentType === 'paystack'
            ? $this->amount * 0.025
            : min($this->amount * 0.01, 300);
        $this->amount += $this->processingFee;
    }
    public function submitPayment(){
        $this->validate();
        $rental = Rental::findOrFail($this->rentalId);
        
            // انشاء سجل دفع
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'tool_id' => $rental->tool_id,
                'rental_id' => $this->rentalId,
                'amount' => $this->amount,
                'deposit_amount' => $this->depositAmount,
                'rental_amount' => $this->rentalAmount,
                'processingFee' => $this->processingFee,
                'payment_type' => $this->paymentType,
                'status' => $this->paymentType === 'paystack' ? 'pending' : 'awaiting_confirmation',
                'delivery_code' => Str::random(6),  // كود تسليم عشوائي
            ]);
            if ($this->paymentType === 'paystack') {
                // Route To Paystack Checkout
                $paystackService = new PaystackService();
                $paymentUrl = $paystackService->initiatePayment(
                    $payment->id,
                       $this->amount * 100,
                        Auth::user()->email,
                        route('payment.verify', ['payment_id' => $payment->id])
                );
                return redirect()->away($paymentUrl);
            }else{
                // حفظ إثبات الدفع للتحويل البنكي
                $path = $this->proofOfPayment->store('proof_of_payment', 'public');
                $payment->update(['proof_of_payment' => $path]);

                // ارسال اشعار لتاكيد المعاملة
                \Mail::to('tgza0533@gmail.com')->queue(new \App\Mail\PaymentProofUploaded($payment));

                session()->flash('message', app()->getLocale() == 'ha' ? 'An tura da  Payment. yana jirar tabbatarwaa.' : 'Payment submit. Please wait for confirmation.');
            }
            $rental->update(['is_paid' => true, 'payment_status' => 'awaiting_comfirmation']);

            return redirect()->route('payments.index');
    }
    // public function render()
    // {
    //     return view('livewire.payment-form');
    // }
}
