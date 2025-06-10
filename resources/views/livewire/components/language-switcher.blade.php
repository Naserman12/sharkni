<div>
    {{-- The best athlete wants his opponent at his best. --}}
    @if(Auth()->user())    
    @php
     $user = Auth()->user();
     app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
     session()->put(['locale' => $user->language]); // تخزين اللغة في الجلسة
    @endphp
        <div x-data="{ lang: ''}" class=" relative inline-block text-left">
            <select x-model="lang" wire:model.lazy="language" class=" p-2 rounded text-white bg-blue-600" id="">
                <option class="" value=""><i class="fas fa-language"></i>language </option>
                <option class="" value="en">English</option>
                <option class="" value="ha">Hausa</option>
            </select>
        </div>
        @else
       @php 
        app()->setLocale(session('lang')); //تعين اللغة بناء على المستخدم
        session()->put(['locale' => session('language')]); // تخزين اللغة في الجلسة
        @endphp
        <select onchange="window.location.href = this.value;" class="p-2 rounded text-gray-800 bg-blue-300">
                        <option value="" data-icon="fa-language">language</option>
                        <option value="{{   url('lang/ha')  }}">Hausa</option>
                        <option value="{{   url('lang/en')  }}">English</option>
                        <!-- <option value="{{   url('lang/ar') }}">Arabic</option> -->
        </select>
     @endif
</div>
