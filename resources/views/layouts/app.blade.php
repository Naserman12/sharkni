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
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <div>
        <!-- navbar -->
         <nav class=" bg-gray-200 p-4 ">
             <div class=" container mx-auto flex justify-between items-center">
                 <a href="{{ route('dashboard') }}" class=" text-xl font-bold">{{ config('app.name', 'Sharkni') }}</a>
                 <div class="">
                 <a href="{{ route('tools.index') }}" class=" bg-gray-100 mr-4">{{ app()->getLocale() == 'ha' ? 'Kayan Aiki' : 'Tools'  }}</a>|
                 <a href="{{ route('tools.add') }}" class=" mr-4">{{ app()->getLocale() == 'ha' ? 'qrar kayan Aiki' : 'Add Tool'  }}</a>|
                 <a href="{{ route('logout') }}" class=" mr-4">{{ app()->getLocale() == 'ha' ? 'Fita' : 'Logout '   }}</a>
                 </div>
             </div>
         </nav>
        <!-- Navbar End -->
            <!-- Page Content -->
            <main class="min-h-screen bg-gray-500">
                {{ $slot }}
            </main>
            </div>
        @livewireScripts
    </body>
</html>
