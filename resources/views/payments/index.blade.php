<x-app-layout>
    <div class="py-12">
         @php
         $user = auth()->user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // ت
         @endphp
         @php 
        app()->setLocale(session('lang')); //تعين اللغة بناء على المستخدم
        session()->put(['locale' => session('language')]); // تخزين اللغة في الجلسة
        @endphp
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class=" bg-gray-300 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-200  border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">{{ __('messages.your payments') }}</h1>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-300">
                                <th class="border p-2">{{ __('messages.Payment ID') }}</th>
                                <th class="border p-2">{{ __('messages.tools') }}</th>
                                <th class="border p-2">{{ __('messages.Amount') }}</th>
                                <th class="border p-2">{{ __('messages.status') }}</th>
                                <th class="border p-2">{{ __('messages.Proof') }}</th>
                                <th class="border p-2">{{ __('messages.Payment Method') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td class="border p-2">{{ $payment->id }}</td>
                                    <td class="border p-2">{{ $payment->tool->name }}</td>
                                    <td class="border p-2">{{ number_format($payment->amount, 2) }} NGN</td>
                                    <td class="border p-2">{{ __($payment->status) }}</td>
                                    <td class="border p-2">{{ __($payment->proof_of_payment) }}</td>
                                    <td class="border p-2">{{ __($payment->payment_method) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>