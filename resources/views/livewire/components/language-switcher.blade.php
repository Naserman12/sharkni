<div>
    {{-- The best athlete wants his opponent at his best. --}}
        @php
     $user = Auth()->user();
     app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
     session(['locale' => $user->language]); // تخزين اللغة في الجلسة
    @endphp
    <div x-data="{ lang: 'en'}" class=" relative inline-block text-left">
        <select x-model="lang" wire:model.lazy="language" class=" p-2 rounded text-white bg-blue-600" id="">
            <option class="" value="en">{{ __('English') }}</option>
            <option class="" value="ha">{{__('Hausa') }}</option>
        </select>
    </divء>
</div>
