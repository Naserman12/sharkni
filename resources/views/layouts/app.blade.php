<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- fontawesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gradient-to-r from-red-500 via-orange-500 to-yellow-400 ">
            @php
            if(session()->has('language')){
            app()->setLocale(session('language'));
            }
            @endphp
        <div>
        <!-- navbar -->
         <nav class=" bg-gradient-to-r from-red-600 via-orange-600 to-yellow-400 p-4 ">
             <div class=" container mx-auto flex justify-between items-center">
                 <a href="{{ route('dashboard') }}" class=" text-xl font-bold">{{ config('app.name', 'Sharkni') }}</a>
                 <div class="">
                    <!-- زر القائم الجانية على الجوال -->
                 <button id="menu-toggle" class=" md:hidden focus:outline-none" >
                    <i class=" fas fa-bars text-2xl"></i>
                 </button>
                 <!-- Notifications -->
                 <div id="menu" class=" hidden md:flex md:items-center md:space-x-4 flex-col md:flex-row absolute md:static top-16 left-0 w-full md:w-auto bg-blue-200  md:bg-transparent p-4 md:p-0 shadow-md md:shadow-none ">
                     <a href="{{ route('tools.index') }}" class=" block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 {{ request()->routeIs('tools.index') ? ' bg-gray-500 p-2 rounded' : '' }}">{{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tools'  }}</a>
                     <a href="{{ route('tools.add') }}"   class=" block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 {{ request()->routeIs('tools.add') ? ' bg-gray-500 p-2 rounded' : '' }}">{{ app()->getLocale() == 'ha' ? 'qrar kayan Aiki' : 'Add Tool'  }}</a>
                     <a href="{{ route('rentals.index') }}"   class=" block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 {{ request()->routeIs('rentals.index') ? ' bg-gray-500 p-2 rounded' : '' }}">{{ app()->getLocale() == 'ha' ? 'Neman Aro' : 'Rentals'  }}</a>
                     <a href="{{ route('damage.report') }}"   class=" block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 {{ request()->routeIs('damage.report') ? ' bg-gray-500 p-2 rounded' : '' }}">{{ app()->getLocale() == 'ha' ? 'Rahoton Lalacewa' : 'Report Damage'  }}</a>
                     <a href="{{ route('categories.add') }}"   class=" block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 {{ request()->routeIs('categories.add') ? ' bg-gray-500 p-2 rounded' : '' }}">{{ app()->getLocale() == 'ha' ? 'Qara Nau\'i ' : 'Add Category'  }}</a>
                     <a href="{{ route('profile') }}"     class=" block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 {{ request()->routeIs('profile') ? ' bg-gray-500 p-2 rounded' : '' }}">{{ app()->getLocale() == 'ha' ? 'Bayanan Mutun' : 'Profile'  }}</a>
                     <a href="{{ route('logout') }}"      class=" block md:inline-block py-2 md:py-0 hover:underline text-center md:text-left mr-4 bg-red-500 {{ request()->routeIs('logout') ? ' bg-red-500 p-2 rounded' : '' }}">{{ app()->getLocale() == 'ha' ? 'Fita' : 'Logout '   }}</a>
                     <div class="mt-2 md:mt-0">
                         @livewire('components.language-switcher')
                     </div>
                     @auth
                      @livewire('pages.notifications.notifications-list')
                     @endauth
                 </div>
                 </div>
             </div>
         </nav>
        <!-- Navbar End -->
            <!-- Page Content -->
            <main class="min-h-screen bg-gradient-to-r from-red-400 via-orange-300 to-yellow-200">
                
                {{ $slot }}
            </main>
            </div>
        @livewireScripts
        <script>
           window.addEventListener('languageChanged', () =>{
                    window.location.reload();
            });
        </script>
    </body>
</html>
