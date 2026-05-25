<!DOCTYPE html>
<html>
<head>
     @vite(['resources/css/app.css', 'resources/js/app.js'])
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @livewireStyles
</head>

<body>
    @include('layouts.includes.app-header')
    <main>
        {{ $slot }}
    </main>
    
    @include('layouts.includes.app-footer')
    @livewireScripts

</body>
</html>