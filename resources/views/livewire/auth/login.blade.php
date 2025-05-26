    @extends('layouts.app')
    @section('content')
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 px-4">
    {{-- In work, do what you enjoy. --}}
  <form wire:submit.prevent="login" 
    class="bg-white bg-opacity-90 backdrop-blur-md shadow-xl rounded-xl p-10 max-w-md w-full"
    dir="rtl"
  >
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">Login</h1>
    
    <input
      type="email"
      wire:model="email"
      placeholder="email"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="email"
    />
    
    <input
      type="password"
      wire:model="password"
      placeholder="password"
      class="w-full mb-6 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="current-password"
    />
    
    <button
      type="submit"
      class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-3 rounded-lg shadow-lg transition"
    >
      login
    </button>
    
    <p class="mt-6 text-center text-gray-600">
      Do not have account?
      <a href="{{ route('register') }}" class="text-purple-600 hover:underline font-semibold"> Register Now</a>
    </p>
  </form>
</div>

@endsection


