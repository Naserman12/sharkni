<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">{{ __('messages.your payments') }}</h1>
                    <table class="w-full border">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="border p-2">{{ __('messages.payment ID') }}</th>
                                <th class="border p-2">{{ __('messages.tool') }}</th>
                                <th class="border p-2">{{ __('messages.amount') }}</th>
                                <th class="border p-2">{{ __('messages.status') }}</th>
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