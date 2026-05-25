<footer class="bg-gradient-to-r from-orange-600 via-red-500 to-yellow-500 text-white mt-10 shadow-inner">

    <div class="container mx-auto px-4 py-6 flex flex-col md:flex-row items-center justify-between gap-3">

        <!-- Left -->
        <div class="text-sm text-center md:text-left">
            © {{ date('Y') }} {{ config('app.name', 'Sharkni') }}. All rights reserved.
        </div>

        <!-- Center -->
        <div class="flex gap-4 text-sm">
            <a href="{{ route('home') }}" class="hover:text-yellow-200 transition">Home</a>
            <a href="{{ route('tools.index') }}" class="hover:text-yellow-200 transition">Tools</a>
            <a href="{{ route('profile') }}" class="hover:text-yellow-200 transition">Profile</a>
        </div>

        <!-- Right (optional social icons) -->
        <div class="flex gap-3 text-lg">
            <a href="#" class="hover:text-yellow-200 transition">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="#" class="hover:text-yellow-200 transition">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="hover:text-yellow-200 transition">
                <i class="fab fa-instagram"></i>
            </a>
        </div>

    </div>

</footer>

<!-- Scripts فقط بدون تغيير لوجيك -->
<script>
    window.addEventListener('languageChanged', () => {
        window.location.reload();
    });
</script>