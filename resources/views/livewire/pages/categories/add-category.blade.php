<div class=" container mx-auto py-10">
            @php
            $user = Auth()->user();
            app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
            session(['locale' => $user->language]); // تخزين اللغة في الجلسة
            @endphp
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class=" bg-blue-300 rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <!-- title -->
         <h1 class=" text-3xl font-bold mb-6 flex items-center">
            <i class="fas fa-plus-circle mr-2"></i>
            {{ app()->getLocale() == 'ha' ? 'Qara Nau\'i ': 'Add category'}}
         </h1>

         <!-- messages -->
              <!-- messages -->
         @if (session('message'))
         <div class=" mb-4 p-2 bg-green-200 text-green-700">
             {{ session('message') }} 
            </div>
         @endif
        <!-- Error messages  -->
         @error('form')  
         <div class=" mb-4 p-2 bg-red-200 text-red-700">
             {{ $message }} 
            </div>
         @enderror
         <form  wire:submit.prevent="addCategory" class=" space-y-4" >
            <!-- name -->
             <div class="">
                <label for="name" class=" block text-gray-800 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Suba (Turanci)' : 'Name (English)' }}
                </label>
                <input type="text" id="name" wire:model="name" class=" w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Kayan Lantatki' : 'Elecrical'}}">
                @error('name')
                    <span class=" text-red-700 bg-red-200">{{ $message }}</span>
                @enderror
            </div>
            <!-- name_ha -->
            <div class="">
                <label for="name_ha" class=" block text-gray-800 font-semibold">
                    {{ app()->getLocale() == 'ha' ? 'Suba (Hausa)' : 'Name (Hausa)' }}
                </label>
                <input type="text" id="name_ha" wire:model="name_ha" class=" w-full p-2 border rounded" placeholder="{{ app()->getLocale() == 'ha' ? 'Kayan Lantatki' : 'Kayan Lantarki'}}">
                @error('name_ha')
                    <span class=" text-red-700 bg-red-200">{{ $message }}</span>
                @enderror
             </div>
            <!-- submit button -->
             <button type="submit" class=" bg-blue-500 text-yellow-100 p-3 rounded-lg w-full hover:bg-blue-700 flex items-center justify-center">
                <i class="fas fa-plus"></i>
                {{ app()->getLocale() == 'ha' ? 'Qara' : 'Add' }}
             </button>
        </form>
    </div>
</div>
