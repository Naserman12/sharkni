<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    <h2 class="text-2xl font-bold mb-4">إرسال بريد إلكتروني</h2>

    @if (session()->has('message'))
        <div class="mb-4 text-green-600">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-4 text-green-600">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="send" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700">البريد الإلكتروني</label>
            <input type="email" wire:model.defer="email" class="w-full border border-gray-300 rounded p-2">
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">الرسالة</label>
            <textarea wire:model.defer="message" rows="4" class="w-full border border-gray-300 rounded p-2"></textarea>
            @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            إرسال
        </button>
    </form>
</div>
</div>
