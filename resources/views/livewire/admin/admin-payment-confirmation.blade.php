<div class="p-6">
    <h1 class="text-2xl font-bold mb-6">{{ __('Pending Payments') }}</h1>
    <table class="w-full border">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-2">{{ __('Payment ID') }}</th>
                <th class="border p-2">{{ __('User') }}</th>
                <th class="border p-2">{{ __('Amount') }}</th>
                <th class="border p-2">{{ __('Proof') }}</th>
                <th class="border p-2">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $payment)
                <tr>
                    <td class="border p-2">{{ $payment->id }}</td>
                    <td class="border p-2">{{ $payment->user->name }}</td>
                    <td class="border p-2">{{ number_format($payment->amount, 2) }} NGN</td>
                    <td class="border p-2">
                        @if ($payment->proof_of_payment)
                            <a href="{{ Storage::url($payment->proof_of_payment) }}" target="_blank" class="text-blue-500">{{ __('View Proof') }}</a>
                        @endif
                    </td>
                    <td class="border p-2">
                        <button wire:click="confirmPayment({{ $payment->id }})" class="bg-green-500 text-white px-4 py-2 rounded">{{ __('Confirm') }}</button>
                        <button wire:click="rejectPayment({{ $payment->id }})" class="bg-red-500 text-white px-4 py-2 rounded">{{ __('Reject') }}</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>