
<div class=" min-h-screen flex items-center justify-center">
  @php 
        app()->setLocale(session('lang')); //تعين اللغة بناء على المستخدم
        session()->put(['locale' => session('language')]); // تخزين اللغة في الجلسة
   @endphp
<div class="w-full max-w-md  mx-auto bg-gradient-to-t from-gray-300  to-gray-400 px-4 hover:p-5">
  <h1 class="text-3xl  font-bold  mb-8 text-center">{{__('messages.register') }}</h1>
  @if (session('message'))
  <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
    {{ session('message')}}
  </div>   
  @endif
  @error('form')
  <div class="mb-4 p-2 bg-red-100 text-red-700 rounded">
    {{ $message}}
  </div>   
  @enderror
  <form wire:submit.prevent="register">
    <!-- Name -->
    <div class="mb-4">
      <label for="name" class=" block text-gray-900">
        {{ __('messages.name')}}
      </label>
      <input
        type="text"
        wire:model="name"
        id="name"
        class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
        autocomplete="off"
      />
      @error('name')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
    </div>
    <!-- Email -->
    <div class="mb-4">
      <label for="email" class=" block text-gray-900">
        {{ __('messages.email') }}
      </label>
    <input
      type="email"
      wire:model="email"
      id="email"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="off"
      />
       @error('email')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
    </div>
      <!-- Phone -->
       <div class="mb-4">
         <label for="phone" class=" block text-gray-900">
           {{ __('messages.phone') }}
      </label>
    <input
      type="text"
      wire:model="phone"
      id="phone"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="off"
      />
       @error('phone')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
    </div>
    <!-- Address -->
     <div class="mb-4">
       <label for="address" class=" block text-gray-900">
         {{ app()->getLocale() == 'ha' ? 'Adireshi' : 'Address' }} ({{ app()->getLocale() == 'ha' ? 'Na zaii' : 'Optional' }})
      </label>
    <input
      type="text"
      wire:model="address"
      placeholder="address"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="off"
      />
       @error('address')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
    </div>
    <!-- Password -->
     <div class="mb-4">
       <label for="password" class=" block text-gray-900">
         {{ __('messages.password') }}
      </label>
    <input
      type="password"
      wire:model="password"
      id="password"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="new-password"
      />
       @error('password')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
    </div>
    <!-- Confirm Password -->
     <div class="mb-4">
       <label for="password_confirmation" class=" block text-gray-900">
         {{ __('messages.confirm_password')}}
        </label>
        <input
        type="password"
        wire:model="password_confirmation"
        id="password_confirmation"
        class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
        autocomplete="new-password"
        />
         @error('napassword_confirmationme')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
      </div>
      <!-- Language -->
       <div class="mb-4">
         <label for="address" class=" block text-gray-900">
           {{ app()->getLocale() == 'ha' ? 'Harshe' : 'Language' }}
          </label>
         <select name="language" wire:model="language" id="language">
          <option value="en"> {{ app()->getLocale() == 'ha' ? 'Turanci' : 'English' }}</option>
          <option value="ha"> {{ app()->getLocale() == 'ha' ? 'Hausa' : 'Hausa' }}</option>
         </select>
       @error('language')
      <span class=" text-red-500 text-sm" >{{ $message }}</span>
      @enderror
        </div>
        <!-- Submit button -->
         <div class="mb-4">
            <button
              type="submit"
              class="w-full bg-gradient-to-t from-pink-700 to-orange-400 hover:from-pink-950 hover:to-orange-500 text-white font-bold py-3 rounded-lg shadow-lg transition"
            >
            {{ __('messages.register') }}  
            </button>
         </div>
         <!-- Login Link -->
    <div class=" text-center">
      <a href="{{ route('login') }}" class=" bg-blue-400 text-white p-2 rounded hover:bg-blue-600">
       {{ app()->getLocale() == 'ha' ? 'Kana da asusu? Shiga' : 'Already have an account? Login' }}  
      </a>
    </div> 
  </form>
</div>
</div>
