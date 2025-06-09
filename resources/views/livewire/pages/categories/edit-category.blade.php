<div>
     @php
            $user = auth()->user();
            app()->setLocale($user->language); //تعين اللغة بناء على المستخدم
            session(['locale' => $user->language]); // تخزين اللغة في الجلسة
     @endphp
    {{-- Be like water. --}}
    <div class="container mx-auto py-10">
    <div class="bg-yellow-200 rounded-lg shadow-lg p-6 max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 flex items-center">
            <i class="fas fa-edit mr-2"></i>
            {{ __('messages.edit_category') }} #{{ $category->id }}
        </h1>

        @if (session('message'))
            <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="updateCategory" class="space-y-4">
            <!-- الاسم (الإنجليزية) -->
            <div>
                <label for="name" class="block text-gray-700 font-semibold">
                    {{ __('messages.name_en') }}
                </label>
                <input type="text" id="name" wire:model="name" class="w-full p-2 border rounded">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- الاسم (الهوسا) -->
            <div>
                <label for="name_ha" class="block text-gray-700 font-semibold">
                    {{ __('messages.name_ha') }}
                </label>
                <input type="text" id="name_ha" wire:model="name_ha" class="w-full p-2 border rounded">
                @error('name_ha') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <!-- زر الحفظ -->
            <button type="submit" class="bg-blue-500 text-white p-3 rounded-lg w-full hover:bg-blue-600 flex items-center justify-center">
                <i class="fas fa-save mr-2"></i>
                {{ __('messages.save') }}
            </button>
        </form>
    </div>
</div>
</div>
