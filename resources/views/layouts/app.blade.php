<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'منصة الأدوات' }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen p-6">
        @yield('content')
    </div>
    @livewireScripts
</body>
</html>
