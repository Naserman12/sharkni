<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\PaystackTransaction;
use App\Models\Rental;
use Illuminate\Support\Str;
use App\Services\PaystackService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\WithFileUploads;
use Unicodeveloper\Paystack\Paystack;

class PaymentForm extends Component
{
    use WithFileUploads;
    public $rental, $rentalAmount;
    public $amount;
    public $email;

    public  $toolId, 
            $rentalId,
            $paymentType = 'full', 
            $paymentMethod  = 'paystack',
            $showBankDetails = false,
            $paymentCompleted = false,
            $bankReceipt,
            $payment;
    protected $paystackService;

    protected $rules =[
                'paymentType' => 'required|in:full,deposit',
                'paymentMethod' => 'required|in:paystack,bank_transfer',
                'bankReceipt' => 'nullable|file|image|max:2048',
            ];
    public function boot(PaystackService $paystackService)
    {
        $this->paystackService = $paystackService;
    }
    public function mount( $rentalId, $toolId)
    {
        $this->rental = Rental::findOrFail($rentalId);
        $this->toolId = $toolId;
        $this->rentalId = $rentalId;
        $this->showBankDetails = !$this->showBankDetails;
        $this->rentalAmount = $this->rental->deposit_amount ?? 500;
        $this->amount = 500;
        $this->recalculateAmount();
        // dd('This Amoun = '.$this->amount);
    }
    
    public function initiatePayment()
    {
        $this->validate();
        // dd($this->paystackService);
        $depositAmount = $this->amount  +100;
        $processingFee = $this->rentalAmount + 200;
        $totalAmount = $this->rentalAmount + $depositAmount + $processingFee;

        // إنشاء السجل في جدول المدفوعات
        try {
            $this->payment = Payment::create([
                'user_id' => Auth::id(),
                'rental_id' => $this->rentalId,  // الربط مع الطلب
                'tool_id' => $this->toolId,  // الربط مع الأداة
                'amount' => $totalAmount,  // المبلغ الإجمالي
                'deposit_amount' => $depositAmount,  // مبلغ التأمين
                'rental_amount' => $this->rentalAmount,  // مبلغ الإيجار
                'processing_fee' => $processingFee,  // رسوم المعالجة
                'payment_type' => $this->paymentType,  // نوع الدفع (في هذه الحالة Paystack)
                'status' => Payment::STATUS_AWAITING_COMFIRMATION,  // حالة الدفع (معلق)
                'payment_method' => $this->paymentMethod,  // وسيلة الدفع
                'delivery_code' => Str::random(6),  // إذا كان موجودًا
                'is_delivered' => false,
                'refund_status' => 'pending',  // حالة الاسترداد
            ]);
            // dd($this->payment);
            if ($this->paymentMethod === 'paystack') {
                return $this->initiatePaystackPayment();
            }
            // $this->showBankDetails = true;
            $this->uploadBankReceipt();
        } catch (\Exception $e) {
            Log::error('Payment initiation failed: ' . $e->getMessage());
            session()->flash('error', __('Failed to initiate payment.'));
        }
    }
    private function initiatePaystackPayment(){
        // dd('This Amoun = '.$this->amount);
        try {
            $result = $this->paystackService->initiatePayment($this->payment, Auth::user()->email);
           
            if ($result['status']) {
                return redirect()->away($result['authorization_url']);
            }else {
            $this->addError('payment', $result['message']);
            $this->payment->update(['status' => Payment::STATUS_FAILED]);
        }
    } catch (\Exception $e) {
        dd('سبب الخطـأ. ' .$e->getMessage());
        $this->payment->update(['status' => Payment::STATUS_FAILED]);
        $this->addError('payment', 'Failed to payment '.$e->getMessage());
    }
}
    public function uploadBankReceipt(){
        if (!$this->payment) {
            echo'payment record not found. Please try again.';
            return;
        }
        $this->validate(['bankReceipt' => 'required|image|max:2048']);
        // dd($this->payment);
        $path = $this->bankReceipt->store('receipts', 'public');

        $updatePaynebt = $this->payment->update([
            'proof_of_payment' => $path,
            'status' => Payment::STATUS_AWAITING_COMFIRMATION
        ]);
            dd('Update Payment = '.$this->payment);
        $this->paymentCompleted = true;
        session()->flash('success', 'Receipt uploaded successfully! We will verify payment soon');
    }
    public function updatedPaymentType()    {
    $this->recalculateAmount();
    }

    public function updatedPaymentMethod(){
        $this->recalculateAmount();
    }

    private function recalculateAmount()
    {
        if ($this->paymentType === 'deposit') {
            $this->amount = 500;
        } else {
            $this->amount = 600;
        }
    }


    public function render()
    {
        return view('livewire.payment-form')->layout('layouts.app');
    }
}
