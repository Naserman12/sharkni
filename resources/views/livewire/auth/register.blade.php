@extends('layouts.app')
@section('content')
<div class=" min-h-screen flex items-center justify-center bg-gray-300">
<div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-400  to-pink-200 px-4">
  <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">{{ app()->getLocale() == 'ha' ? 'Ti rajista' : 'Register' }}</h1>
  <form wire:submit.prevent="register" 
    class="bg-white bg-opacity-90 backdrop-blur-md shadow-xl rounded-xl p-10 max-w-md w-full"
    dir="rtl"
  >
    <input
      type="text"
      wire:model="name"
      placeholder="الاسم"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="off"
    />
    
    <input
      type="email"
      wire:model="email"
      placeholder="email"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="off"
    />
    
    <input
      type="text"
      wire:model="phone"
      placeholder="phone"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="off"
    />
    
    <input
      type="password"
      wire:model="password"
      placeholder="password"
      class="w-full mb-4 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="new-password"
    />
    
    <input
      type="text"
      wire:model="language"
      placeholder="اللغة (اختياري)"
      class="w-full mb-6 px-5 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-4 focus:ring-purple-400 transition"
      autocomplete="off"
    />
    
    <button
      type="submit"
      class="w-full bg-gradient-to-r from-purple-600 to-pink-600 hover:from-pink-600 hover:to-purple-600 text-white font-bold py-3 rounded-lg shadow-lg transition"
    >
      تسجيل
    </button>
  </form>
</div>
</div>
@endsection
