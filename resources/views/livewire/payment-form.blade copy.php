<div>
   
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">{{ __('messages.Make Payment') }}</h2>
    <form wire:submit.prevent="submitPayment" class="space-y-4">
        <!-- نوع الدفع -->
        <div>
            <label for="paymentType" class="block text-sm font-medium text-gray-700">{{ __('messages.Payment Method') }}</label>
            <select id="paymentType" wire:model.lazy="paymentType" class="mt-1 block w-full p-2 border rounded-md">
                <option value="paystack">{{ __('messages.Pay with Paystack') }}</option>
                <option value="virtual_account">{{ __('messages.Pay with Bank Transfer') }}</option>
            </select>
            @error('paymentType') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
        </div>
        <span> {{ __('messages.welcome') }}
 {{ app()->getLocale() }}
 </span>
        <!-- تفاصيل المبلغ -->
        <div class="border p-4 rounded-md bg-gray-50">
            <p>{{ __('messages.Rental Amount') }}: {{ number_format($rentalAmount, 2) }} NGN</p>
            <p>{{ __('messages.Deposit Amount') }}: {{ number_format($depositAmount, 2) }} NGN</p>
            <p>{{ __('messages.Processing Fee') }}: {{ number_format($processingFee, 2) }} NGN ({{ $paymentType == 'paystack' ? '1.5% + 150' : '1% max 300 NGN' }})</p>
            <p class="font-bold">{{ __('Total Amount') }}: {{ number_format($amount, 2) }} NGN</p>
        </div>
        <!-- تفاصيل الحساب الافتراضي (للتحويل البنكي) -->
        @if ($paymentType === 'virtual_account')
            <div x-data="{ showDetails: false }" class="border p-4 rounded-md bg-gray-50">
                <button type="button" @click="showDetails = !showDetails" class="text-blue-500">
                    {{ __('View Bank Details') }}
                </button>
                <div x-show="showDetails" class="mt-2">
                    <p><strong>{{ __('messages.Bank Name') }}:</strong> {{ $virtualAccountDetails['bank_name'] ?? 'Paystack-Titan' }}</p>
                    <p><strong>{{ __('messages.Account Number') }}:</strong> {{ $virtualAccountDetails['account_number'] ?? 'N/A' }}</p>
                    <p><strong>{{ __('messages.Account Holder') }}:</strong> {{ $virtualAccountDetails['holder_name'] ?? 'Shaarikii Escrow' }}</p>
                    <p class="text-sm text-gray-600">{{ __('messages.Please transfer the amount and upload proof of payment.') }}</p>
                </div>
            </div>
            <!-- رفع إثبات الدفع -->
            <div>
                <label for="proofOfPayment" class="block text-sm font-medium text-gray-700">{{ __('Proof of Payment') }}</label>
                <input type="file" id="proofOfPayment" wire:model="proofOfPayment" class="mt-1 block w-full p-2 border rounded-md">
                @error('proofOfPayment') <span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>
            @endif 
            <!-- زر الإرسال -->
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600">
                {{ __('messages.Submit Payment') }}
            </button>
    </form>
</div>
</div>
