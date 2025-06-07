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
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
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
            <nav class="bg-gradient-to-r from-red-600 via-orange-600 to-yellow-400 p-4 relative z-50">
                <div class="container mx-auto flex justify-between items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-white">{{ config('app.name', 'Sharkni') }}</a>

                    <!-- Mobile Menu Button -->
                    <div class="flex items-center space-x-4">
                        @auth
                            <!-- Notifications (Visible on all screens) -->
                            <div class="relative">
                                @livewire('pages.notifications.notifications-list')
                            </div>
                        @endauth

                        <button id="menu-toggle" @click="open = !open" class="md:hidden focus:outline-none text-white text-2xl">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>

                    <!-- Menu -->
                    <div x-data="{ open: false }" :class="{'block': open, 'hidden': !open}" class="hidden md:flex md:items-center md:space-x-4 flex-col md:flex-row absolute md:static top-16 left-0 w-full md:w-auto bg-white md:bg-transparent p-4 md:p-0 shadow-md md:shadow-none transition-all duration-300">

                        <!-- Tools Dropdown -->
                        <div x-data="{ toolsOpen: false }" class="relative group">
                            <button @click="toolsOpen = !toolsOpen" class="text-xl font-bold text-gray-800 hover:underline focus:outline-none">
                                {{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tools' }}
                            </button>
                            <div x-show="toolsOpen" @click.outside="toolsOpen = false" class="absolute bg-white shadow-lg rounded mt-2 p-2 min-w-[160px] z-50">
                                <a href="{{ route('tools.index') }}" class="block px-4 py-2 hover:bg-gray-100">عرض الأدوات</a>
                                <a href="{{ route('tools.add') }}" class="block px-4 py-2 hover:bg-gray-100">إضافة أداة</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">تعديل أداة</a>
                            </div>
                        </div>

                        <!-- Categories Dropdown -->
                        <div x-data="{ catOpen: false }" class="relative group">
                            <button @click="catOpen = !catOpen" class="text-xl font-bold text-gray-800 hover:underline focus:outline-none">
                                {{ app()->getLocale() == 'ha' ? 'Nau\'i' : 'Categories' }}
                            </button>
                            <div x-show="catOpen" @click.outside="catOpen = false" class="absolute bg-white shadow-lg rounded mt-2 p-2 min-w-[160px] z-50">
                                <a href="{{ route('categories.add') }}" class="block px-4 py-2 hover:bg-gray-100">إضافة تصنيف</a>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100">تعديل التصنيفات</a>
                            </div>
                        </div>

                        <!-- Rentals -->
                        <a href="{{ route('rentals.index') }}" class="text-xl font-bold text-gray-800 hover:underline">
                            {{ app()->getLocale() == 'ha' ? 'Neman Aro' : 'Rentals' }}
                        </a>

                        <!-- Report Damage -->
                        <a href="{{ route('damage.report') }}" class="text-xl font-bold text-gray-800 hover:underline">
                            {{ app()->getLocale() == 'ha' ? 'Rahoton Lalacewa' : 'Report Damage' }}
                        </a>

                        <!-- Profile -->
                        <a href="{{ route('profile') }}" class="text-xl font-bold text-gray-800 hover:underline">
                            {{ app()->getLocale() == 'ha' ? 'Bayanan Mutun' : 'Profile' }}
                        </a>

                        <!-- Logout -->
                        <a href="{{ route('logout') }}" class="text-xl font-bold text-red-600 hover:underline">
                            {{ app()->getLocale() == 'ha' ? 'Fita' : 'Logout' }}
                        </a>

                        <!-- Language Switcher -->
                        <div class="mt-2 md:mt-0">
                            @livewire('components.language-switcher')
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
