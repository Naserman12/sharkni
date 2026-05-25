<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-700 via-pink-600 to-orange-500 py-10">

    @php 
        app()->setLocale(session('lang'));
        session()->put(['locale' => session('language')]);
    @endphp

    <div class="w-full max-w-md mx-auto backdrop-blur-xl bg-white/20 shadow-2xl rounded-2xl p-8 border border-white/30">

        <h1 class="text-4xl font-extrabold text-center text-white drop-shadow mb-8">
            {{ __('messages.register') }}
        </h1>

        @if (session('message'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg shadow">
                {{ session('message') }}
            </div>
        @endif

        @error('form')
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-lg shadow">
                {{ $message }}
            </div>
        @enderror

        <form wire:submit.prevent="register" class="space-y-5">

            <!-- Name -->
            <div>
                <label class="block text-white font-semibold mb-1">
                    {{ __('messages.name') }}
                </label>
                <input type="text" wire:model="name"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-purple-300 focus:outline-none shadow-lg" />
                @error('name')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label class="block text-white font-semibold mb-1">
                    {{ __('messages.email') }}
                </label>
                <input type="email" wire:model="email"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-purple-300 focus:outline-none shadow-lg" />
                @error('email')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div>
                <label class="block text-white font-semibold mb-1">
                    {{ __('messages.phone') }}
                </label>
                <input type="text" wire:model="phone"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-purple-300 focus:outline-none shadow-lg" />
                @error('phone')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address -->
            <div>
                <label class="block text-white font-semibold mb-1">
                    {{ app()->getLocale() == 'ha' ? 'Adireshi' : 'Address' }}
                    <span class="text-white/70 text-sm">({{ app()->getLocale() == 'ha' ? 'Na zaii' : 'Optional' }})</span>
                </label>
                <input type="text" wire:model="address"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-purple-300 focus:outline-none shadow-lg" />
                @error('address')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label class="block text-white font-semibold mb-1">
                    {{ __('messages.password') }}
                </label>
                <input type="password" wire:model="password"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-purple-300 focus:outline-none shadow-lg" />
                @error('password')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label class="block text-white font-semibold mb-1">
                    {{ __('messages.confirm_password') }}
                </label>
                <input type="password" wire:model="password_confirmation"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-purple-300 focus:outline-none shadow-lg" />
                @error('password_confirmation')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Language -->
            <div>
                <label class="block text-white font-semibold mb-1">
                    {{ app()->getLocale() == 'ha' ? 'Harshe' : 'Language' }}
                </label>
                <select wire:model="language"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white border border-white/40 focus:ring-4 focus:ring-purple-300 focus:outline-none shadow-lg">
                    <option value="en" class="text-black">English</option>
                    <option value="ha" class="text-black">Hausa</option>
                </select>
                @error('language')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-pink-600 to-orange-400 hover:from-pink-700 hover:to-orange-500 text-white font-bold text-lg shadow-xl transition transform hover:scale-[1.03]">
                {{ __('messages.register') }}
            </button>

            <!-- Login Link -->
            <div class="text-center mt-4">
                <a href="{{ route('login') }}"
                    class="inline-block bg-white/20 text-white px-4 py-2 rounded-lg shadow hover:bg-white/30 transition">
                    {{ app()->getLocale() == 'ha' ? 'Kana da asusu? Shiga' : 'Already have an account? Login' }}
                </a>
            </div>

        </form>
    </div>
</div>
