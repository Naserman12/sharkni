<x-app-layout>
  <div class="py-12">
    @php
        $user = auth()->user();
        app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
        session(['locale' => $user->language]); // تخزين اللغة في الجلسة
    @endphp
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-orange-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class=""> {{ app()->getLocale() == 'ha' ? 'Barka da war haka, ' : 'Hello, '  }}<strong>({{  $user->name  }})</strong></h1> 
                </div>
            </div>
        </div>
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
    </div>    
</x-app-layout>
