<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
<div class=" container mx-auto py-10">
    <div class=" rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
     @php
            $user = Auth()->user();
            app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
            session(['locale' => $user->language]); // تخزين اللغة في الجلسة
     @endphp
        <!-- Title -->
         <h1 class=" text-3xl font-bold mb-6 flex items-center">
            <i class="fas fa-shopping-cart mr-2"></i>
            {{ app()->getLocale() == 'ha' ? 'Neman Aro' : 'Rental Request' }}
         </h1>

         <!-- رسائل  -->
        @if (session('message'))
            <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
                {{ session('message')}}
            </div>   
        @endif

        <!-- الطلبات -->
        <div class=" space-y-4">
            @forelse ($rentals as $rental )
                <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                    <p><strong>{{ __('messages.tool') }}:</strong> {{ $rental->tool->name }}</p>
                    <p><strong>{{ __('messages.borrower') }}:</strong> {{ $rental->borrower->name }}</p>
                    <p><strong>{{ __('messages.status') }}:</strong> {{ $rental->status }}</p>
                    <a href="{{ route('rentals.complete', $rental->id) }}" class="bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                        {{ __('messages.complete') }}
                    </a>
                </div>
            @empty
                <div class=" text-gray-800">{{ app()->getLocale() == 'ha' ? 'Babu neman aro.' : 'No rental requests.' }}</div>
            @endforelse
        </div>
    </div>
</div>
</div>
