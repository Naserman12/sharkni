<div class="container mx-auto py-10">
    {{-- The whole world belongs to you. --}}
    <div class=" bg-yellow-200 rounded-lg shadow-lg p-6">
            @php
            $user = Auth()->user();
            app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
            session()->put(['locale' => $user->language]); // تخزين اللغة في الجلسة
            @endphp
        <!-- ttile -->
         <h1 class=" text-3xl font-bold mb-6 flex items-center ">
            <i class="fas fa-tools"></i>
            {{ __('messages.welcome_title') }}
         </h1>
        <!-- search -->
            <!-- messages -->
         @if (session('message'))
         <div class=" mb-4 p-2 bg-green-200 text-green-700">
             {{ session('message') }} 
         </div>
         @endif
        <!-- Error messages  -->
         @error('error')  
         <div class=" mb-4 p-2 bg-red-200 text-red-700">
             {{ $message }} 
         </div>
         @enderror
         <div class="mb-6">
            <div class=" flex items-center space-x-2 ">
                <input type="text" wire:model.lazy="search" placeholder="{{ __('messages.search') }}" class=" w-full p-2 border rounded">
                <button wire:click="$set('search', '')" class=" bg-gray-600 text-gray-100 p-2 rounded hover:bg-gray-700">
                    <i class="fas fa-times"></i>
                </button>
                <button wire:submit="search" class=" bg-blue-600 text-gray-100 p-2 rounded hover:bg-blue-700">
                    <i class="fas fa-search"></i>
                </button>
            </div>
         </div>
         <!-- Feature Tools -->
        <div class="">
            <h2 class=" text-2xl font-semibold mb-4 flex items-center">
                <i class="fas fa-star mr-2"></i>
                {{ __('messages.featured tools') }}
            </h2>
            @forelse ($featuredTools as $Tool)
                <div class="flex items-center border-b py-4">
                    <div class="w-20 h20 mr-4">
                        @if ($Tool->image_paths && count($Tool->image_paths) > 0)
                            <img src="{{ asset('storage/'.$Tool->image_paths[0]) }}" alt="{{ $Tool->name }}">
                        @else
                            <div class="w-full h-full bg-gray-300 rounded-lg fl items-center justify-center">
                                <span class=" text-gray-800">{{ __('No image') }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h3 class=" text-lg font-semibold">
                            {{ $Tool->name }}  ({{ $Tool->location }})
                        </h3>
                        <p class="text-gray-800">
                            {{ $Tool->is_free ? __('free') : (app()->getLocale() == 'ha' ? 'Hayar ₦'.$Tool->rental_price.' rana' : 'Rent ₦'.$Tool->rental_price.'/day')}}
                        </p>
                        <a href="{{ route('tools.show' , $Tool->id) }}" class="bg-blue-600 text-gray-100 px-3 py-1 rounded hover:bg-blue-700">
                            {{ __('messages.show tool') }}
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-800">{{ __('messages.No featured tools available') }}</p>
            @endforelse
        </div>

    </div>
</div>
