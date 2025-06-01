<div>
     @php
       $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // ت
    @endphp
    {{-- Stop trying to control. --}}
    <div class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-4">{{ __('messages.Confirm Delivery') }}</h2>
    <form wire:submit.prevent="confirmDelivery" class="space-y-4">
        <div>
            <label for="deliveryCode" class="block text-sm font-medium text-gray-700">{{ __('messages.Delivery Code') }}</label>
            <input type="text" id="deliveryCode" wire:model="deliveryCode" class="mt-1 block w-full p-2 border rounded-md">
            @error('deliveryCode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div>
            <label for="proofOfDelivery" class="block text-sm font-medium text-gray-700">{{ __('messages.Proof of Delivery (Optional)') }}</label>
            <input type="file" id="proofOfDelivery" wire:model="proofOfDelivery" class="mt-1 block w-full p-2 border rounded-md">
            @error('proofOfDelivery') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="w-full bg-green-500 text-white p-2 rounded-md hover:bg-green-600">
            {{ __('messages.Confirm Delivery') }}
        </button>
    </form>
</div>
</div>
