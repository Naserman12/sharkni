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
                <div class=" border p-4 rounded-lg">
                    <p><strong>{{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tool' }}</strong> {{ $rental->tool->name }}</p>
                    <p><strong>{{ app()->getLocale() == 'ha' ? 'Mai Aro' : 'Borrower' }}</strong> {{ $rental->borrower->name }}</p>
                    <p><strong>{{ app()->getLocale() == 'ha' ? 'Mai Shi' : 'Lender' }}</strong> {{ $rental->lender->name }}</p>
                    <p><strong>{{ app()->getLocale() == 'ha' ? 'Matsyi' : 'Status' }}</strong> {{ $rental->status }}</p>
                    <p><strong>{{ app()->getLocale() == 'ha' ? 'Ranar Aro' : 'Borrow Date' }}</strong> {{ $rental->borrow_date->format('Y-m-d') }}</p>
                    <p><strong>{{ app()->getLocale() == 'ha' ? 'Ranar Myarwa' : 'Return Date' }}</strong> {{ $rental->return_date->format('Y-m-d')}}</p>
                    <p><strong>{{ app()->getLocale() == 'ha' ? 'Farashin' : 'Total Cost' }}</strong> {{ $rental->total_cost}}</p>
                </div>
                <!-- Butttons -->
                 <div>
                 @if ($rental->status === 'pending')
                     @if ($rental->lender_id === auth()->id())
                     <button wire:click="approve({{ $rental->id }})" class=" bg-green-600 text-nowrap p-2 rounded hover:bg-green-800">
                        {{ app()->getLocale() == 'ha' ? 'Amince' : 'Approve' }}
                     </button>
                     @endif
                     <button wire:click="cancel({{ $rental->id }})" class=" bg-red-500 text-nowrap p-2 rounded hover:bg-red-700">
                        {{ app()->getLocale() == 'ha' ? 'Soke' : 'Cancell' }}
                     </button>
                 @endif
                </div>
            @empty
                <div class=" text-gray-800">{{ app()->getLocale() == 'ha' ? 'Babu neman aro.' : 'No rental requests.' }}</div>
            @endforelse
        </div>
    </div>
</div>
</div>
