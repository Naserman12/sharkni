<x-app-layout>
     @php
       $user = Auth::user();
                app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
                session(['locale' => $user->language]); // ت
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-6">{{ __('messages.Payment for Tool Rental') }}</h1>
                    @if (isset($rental))
                        <livewire:payment-form :rentalId="$rental->id" />
                    @else
                        <p class="text-red-500">{{ __('messages.Error: No rental provided.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>