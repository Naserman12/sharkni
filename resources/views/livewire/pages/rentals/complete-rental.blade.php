<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="container mx-auto py-10">
    <div class="bg-white rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            {{ __('messages.rental_request') }} #{{ $rental->id }}
        </h1>
         @php
             $user = auth()->user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // تخزين اللغة في الجلسة
        @endphp
        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            <!-- تفاصيل الطلب -->
            <div class="bg-gray-100 p-4 rounded-lg">
                <p><strong>{{ __('messages.tool') }}:</strong> {{ $rental->tool->name }}</p>
                <p><strong>{{ __('messages.borrower') }}:</strong> {{ $rental->borrower->name }}</p>
                <p><strong>{{ __('messages.start_date') }}:</strong> {{ date_format($rental->borrow_date, 'Y-m-d-h')}}</p>
                <p><strong>{{ __('messages.end_date') }}:</strong> {{ date_format($rental->return_date, 'Y-m-d-h')  }}</p>
                <p><strong>{{ __('messages.payment_status') }}:</strong>
                    @if ($rental->payment_status === 'none')
                        {{ __('messages.no_payment') }}
                    @elseif ($rental->payment_status === 'insurance_only')
                        {{ __('messages.insurance_paid') }}
                    @elseif ($rental->payment_status === 'full_payment')
                        {{ __('messages.full_paid') }}
                    @endif
                </p>
            </div>

            <!-- تحديث حالة الدفع -->
            <div>
                <label class="block text-gray-700 font-semibold">
                    {{ __('messages.payment_status') }}
                </label>
                <select wire:model="paymentStatus" class="w-full p-2 border rounded">
                    <option value="none">{{ __('messages.none') }}</option>
                    <option value="insurance_only">{{ __('messages.insurance_only') }}</option>
                    <option value="full_payment">{{ __('messages.full_payment') }}</option>
                </select>
                @error('paymentStatus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- الأزرار -->
            <div class="flex space-x-4">
                <button wire:click="acceptRequest" class="bg-green-500 text-white p-3 rounded-lg w-full hover:bg-green-600 flex items-center justify-center">
                    <i class="fas fa-check mr-2"></i>
                    {{ __('messages.accept') }}
                </button>
                <button wire:click="rejectRequest" class="bg-red-500 text-white p-3 rounded-lg w-full hover:bg-red-600 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i>
                    {{ __('messages.reject') }}
                </button>
                <button wire:click="completeRequest" class="bg-blue-500 text-white p-3 rounded-lg w-full hover:bg-blue-600 flex items-center justify-center">
                    <i class="fas fa-check-double mr-2"></i>
                    {{ __('messages.complete') }}
                </button>
            </div>
        </div>
    </div>
</div>
</div>
