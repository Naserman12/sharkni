
<div class=" min-h-screen flex items-center justify-center">
   @php 
        app()->setLocale(session('lang')); //تعين اللغة بناء على المستخدم
        session()->put(['locale' => session('language')]); // تخزين اللغة في الجلسة
    @endphp
    <div class="w-full max-w-md p-4  mx-auto bg-gradient-to-t from-gray-300  to-gray-400 px-4 hover:p-5">
  <h1 class="text-3xl  font-bold  mb-8 text-center">{{__( 'messages.login' )}}</h1>
  @if (session('message'))
  <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
    {{ $message }}
  </div>   
  @endif
  @error('form')
  <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">
    {{ $message }}
  </div>   
  @enderror
    <form wire:submit.prevent="login">
         <!-- Email -->
    <div class="mb-4">
      <label for="email" class=" block text-gray-900">
        {{ __('messages.email')}}
    </label>
    <input
      type="email"
      wire:model="email"
      id="email"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      />
       @error('email')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
    </div>

     <!-- Password -->
     <div class="mb-4">
       <label for="password" class=" block text-gray-900">
           {{ __('messages.password')}}
        </label>
    <input
      type="password"
      wire:model="password"
      id="password"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      />
       @error('password')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
    </div>
    <!-- Remember Me -->
     <div class="mb-4 flex items-center">
        <input type="checkbox" id="remember" wire:wire:model="remember" class="mr-2">
        <label for="remember"  class=" text-gray-700">
     {{__('messages.remember_me') }}
        </label>
     </div>
      <!-- Submit button -->
         <div class="mb-4">
            <button
              type="submit"
              class="w-full bg-gradient-to-t from-pink-700 to-orange-400 hover:from-pink-950 hover:to-orange-500 text-white font-bold py-3 rounded-lg shadow-lg transition"
            >
            {{ __( 'messages.login' ) }}  
            </button>
         </div>

              <!-- Register Link -->
    <div class=" text-center">
      <a href="{{ route('register') }}" class=" bg-blue-800 text-white p-2 rounded hover:bg-blue-950">
       {{ app()->getLocale() == 'ha' ? 'Ba ka da asusu? Yi rajista' : "Don't have an account? Register" }}  
      </a>
    </div>
    </form>
  </div>
  </div>
