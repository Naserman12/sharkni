<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">{{ __('Your Payments') }}</h1>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">{{ __('Payment ID') }}</th>
                                <th class="border p-2">{{ __('Tool') }}</th>
                                <th class="border p-2">{{ __('Amount') }}</th>
                                <th class="border p-2">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    <td class="border p-2">{{ $payment->id }}</td>
                                    <td class="border p-2">{{ $payment->tool->name }}</td>
                                    <td class="border p-2">{{ number_format($payment->amount, 2) }} NGN</td>
                                    <td class="border p-2">{{ __($payment->status) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>