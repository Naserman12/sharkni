<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-purple-700 via-pink-600 to-orange-500 py-10">

    @php 
        app()->setLocale(session('lang'));
        session()->put(['locale' => session('language')]);
    @endphp

    <div class="w-full max-w-md mx-auto backdrop-blur-xl bg-white/20 shadow-2xl rounded-2xl p-8 border border-white/30">

        <h1 class="text-4xl font-extrabold text-center text-white drop-shadow mb-8">
            {{ __('messages.login') }}
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

        <form wire:submit.prevent="login" class="space-y-5">

            <!-- Email -->
            <div>
                <label for="email" class="block text-white font-semibold mb-1">
                    {{ __('messages.email') }}
                </label>
                <input type="email" wire:model="email" id="email"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-pink-300 focus:outline-none shadow-lg" />
                @error('email')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-white font-semibold mb-1">
                    {{ __('messages.password') }}
                </label>
                <input type="password" wire:model="password" id="password"
                    class="w-full px-5 py-3 rounded-xl bg-white/30 text-white placeholder-white/70 border border-white/40 focus:ring-4 focus:ring-pink-300 focus:outline-none shadow-lg" />
                @error('password')
                    <span class="text-red-200 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center space-x-2 text-white">
                <input type="checkbox" id="remember" wire:model="remember"
                    class="w-5 h-5 rounded border-white/50 bg-white/20">
                <label for="remember">{{ __('messages.remember_me') }}</label>
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-pink-600 to-orange-400 hover:from-pink-700 hover:to-orange-500 text-white font-bold text-lg shadow-xl transition transform hover:scale-[1.03]">
                {{ __('messages.login') }}
            </button>

            <!-- Register Link -->
            <div class="text-center mt-4">
                <a href="{{ route('register') }}"
                    class="inline-block bg-white/20 text-white px-4 py-2 rounded-lg shadow hover:bg-white/30 transition">
                    {{ app()->getLocale() == 'ha' ? 'Ba ka da asusu? Yi rajista' : "Don't have an account? Register" }}
                </a>
            </div>

        </form>
    </div>
</div>
