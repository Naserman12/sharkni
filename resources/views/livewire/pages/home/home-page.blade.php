<div>
      @php 
        app()->setLocale(session('lang')); //تعين اللغة بناء على المستخدم
        session()->put(['locale' => session('language')]); // تخزين اللغة في الجلسة
        @endphp
    {{-- Success is as dangerous as failure. --}}
    <div class="container mx-auto py-10">
    <!-- قسم الترحيب -->
    <section class="bg-blue-100 rounded-lg p-6 mb-6 text-center">
        <h1 class="text-4xl font-bold mb-4">{{ __('messages.welcome_title') }}</h1>
        <p class="text-lg text-gray-700">{{ __('messages.welcome_description') }}</p>
    </section>

    <!-- قسم طرق الدفع -->
    <section class="bg-white rounded-lg p-6 mb-6 shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">{{ __('messages.payment_methods_title') }}</h2>
        <p class="text-gray-700">{{ __('messages.payment_methods_description') }}</p>
        <div class="mt-4 flex justify-center space-x-4">
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full">Paystack, Bank Transfer</span>
        </div>
    </section>

    <!-- قسم كيفية الاستخدام -->
    <section class="bg-gray-100 rounded-lg p-6 shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">{{ __('messages.how_to_use_title') }}</h2>
        <ol class="list-decimal list-inside text-gray-700 space-y-2">
            <li>{{ __('messages.how_to_use_step1') }}</li>
            <li>{{ __('messages.how_to_use_step2') }}</li>
            <li>{{ __('messages.how_to_use_step3') }}</li>
            <li>{{ __('messages.how_to_use_step4') }}</li>
        </ol>
    </section>
        @if (auth()->check())
        <div class="mb-1">
            <a href="{{ route('logout') }}">
                <button
                class="w-full bg-gradient-to-r from-red-800 text-white font-bold py-3 rounded-lg shadow-lg transition"
                >
                @lang('messages.logout') 
            </button>
        </a>
    </div>
    @else
    <div class="mb-1">
        <a href="{{ route('login') }}">
            <button
            class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-3 rounded-lg shadow-lg transition"
            >
            @lang('messages.login') 
        </button>
    </a>
</div>
<div class="mb-2">
    <a href="{{ route('register') }}">
        <button
        class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-3 rounded-lg shadow-lg transition"
        >
        @lang('messages.register') 
    </button>
</a>
</div>
@endif
</div>
</div>
